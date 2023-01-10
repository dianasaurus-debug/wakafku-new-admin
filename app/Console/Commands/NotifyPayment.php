<?php

namespace App\Console\Commands;

use App\Models\PaymentReminder;
use App\Models\User;
use App\Models\Waqif;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
        $payment_reminders = PaymentReminder::where('is_activated', true)->get();
        foreach($payment_reminders as $reminder) {
            $waqif = Waqif::where('id', $reminder->waqif_id)->first();
            $user = User::where('id', $waqif->user_id)->first();
            create_firebase_notif($user->fcm_token, 'Waktunya Anda membayar wakaf hari ini!', 'Pembayaran wakaf setiap tanggal '.Carbon::parse($reminder->scheduled_date)->format('d M'));
        }
    }
}
