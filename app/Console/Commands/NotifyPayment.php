<?php

namespace App\Console\Commands;

use App\Models\PaymentMethod;
use App\Models\PaymentReminder;
use App\Models\User;
use App\Models\WaqfTransaction;
use App\Models\Waqif;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Xendit\Xendit;

class NotifyPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pengingat pembayaran wakaf';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $payment_reminders = PaymentReminder::whereNull('transaction_id')->get();

        foreach($payment_reminders as $reminder) {
            $waqif = Waqif::where('id', $reminder->waqif_id)->first();
            $user = User::where('id', $waqif->user_id)->first();
            $payment_method_data = PaymentMethod::where('id', $reminder->payment_method_id)->first();
//            if($payment_method_data->kind=='va'){
//                $secret = env('XENDIT_API_KEY');
//                Xendit::setApiKey($secret);
//                $body = [
//                    "external_id" => 'wakafku-va-' . time(),
//                    "bank_code" => strtoupper($payment_method_data->label),
//                    "name" => $user->name,
//                    "expected_amount" => $reminder->amount,
//                    "is_closed" => true
//                ];
//                $createVA = \Xendit\VirtualAccounts::create($body);
//
//                $object_va = $createVA;
//            }
//            $ref_id = 'wakafku-ewallet-' . time();
//            $transaction = WaqfTransaction::create([
//                'payment_due' => Carbon::parse(Carbon::now())->addHours(12),
//                'reference_code' => isset($object_va) && $payment_method_data->kind != 'ewallet' ? $object_va[config('__constant.EXTERNAL_IDS')[$payment_method_data->kind]] : $ref_id,
//                'payment_code' => isset($object_va) && $payment_method_data->kind != 'ewallet' ? $object_va[config('__constant.PAYMENT_CODES')[$payment_method_data->kind]] : $ref_id,
//                'amount' => $reminder->amount,
//                'payment_method_id' => $payment_method_data->id,
//                'jenis_wakaf' => 'abadi',
//                'atas_nama' => $user->name,
//                'program_id' => $reminder->program_id,
//                'waqif_id' => $waqif->id,
//            ]);
//            $reminder->update(['transaction_id' => $transaction->id]);
            create_notification_data($user->id, 'pembayaran', 'Waktunya Anda membayar wakaf hari ini!', 'Pembayaran wakaf untuk jadwal tanggal '.$reminder->scheduled_date);
            create_firebase_notif($waqif->fcm_token, 'Waktunya Anda membayar wakaf hari ini!', 'Pembayaran wakaf untuk jadwal tanggal '.$reminder->scheduled_date);
        }
    }
}
