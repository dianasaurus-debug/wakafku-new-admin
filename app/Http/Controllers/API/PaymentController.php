<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Program;
use App\Models\User;
use App\Models\WaqfReturn;
use App\Models\WaqfTransaction;
use App\Models\Waqif;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Xendit\Transaction;
use Xendit\Xendit;

class PaymentController extends Controller
{
    public function create_transaction(Request $request){
        try {
            $secret = env('XENDIT_API_KEY');
            Xendit::setApiKey($secret);
            $wakif = Waqif::where('user_id', Auth::id())->with('user')->first();

            $body = [
                "external_id" => 'wakafku-va-' . time(),
                "bank_code" => strtoupper($request->channel),
                "name" => $wakif->user->name,
                "expected_amount" => $request->nominal,
                "is_closed" => true
            ];
            $createVA = \Xendit\VirtualAccounts::create($body);
            $payment_method_data = PaymentMethod::where('label', $request->channel)->first();

            if($createVA){
                $transaction = WaqfTransaction::create([
                    'payment_due' => Carbon::parse(Carbon::now())->addHours(12),
                    'reference_code' =>  $createVA[config('__constant.EXTERNAL_IDS')[$payment_method_data->kind]],
                    'payment_code' => $createVA[config('__constant.PAYMENT_CODES')[$payment_method_data->kind]],
                    'amount' => $request->nominal,
                    'payment_method_id' => $payment_method_data->id,
                    'jenis_wakaf' => $request->jenis,
                    'atas_nama' => isset($request->atas_nama) ? $request->atas_nama : Auth::user()->name,
                    'program_id' => $request->program_id,
                    'waqif_id'  => $wakif->id,
                ]);
                if($request->jenis=='berjangka'){
                    $berjangka_data = WaqfReturn::create([
                        'account_bank' => $request->account_bank,
                        'account_holder' => $request->account_holder,
                        'account_number' => $request->account_number,
                        'amount' => $request->nominal,
                        'returned_at' => Carbon::now()->addYears($request->jangka_waktu),
                        'jangka' => $request->jangka_waktu,
                        'waqf_id' => $transaction->id,
                    ]);
                }
                $transaction_data = WaqfTransaction::where('id', $transaction->id)
                    ->with('program')
                    ->with('payment_method')->first();
                return response()
                    ->json([
                        'success' => true,
                        'message' => 'Berhasil membuat data pembayaran',
                        'data' => $transaction_data
                    ]);
            } else {
                return response()
                    ->json([
                        'success' => false,
                        'message' => 'Terjadi kesalahan di pembayaran',
                    ]);
            }

        } catch (\Exception $exception){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan message : '.$exception->getMessage(),
                    'data' => $body
                ]);
        }

    }
    public function bank_list(Request $request){
        try {
            $all_methods = PaymentMethod::where('is_activated', true)
                ->get();
            return response()
                ->json([
                    'success' => true,
                    'data' => $all_methods,
                    'message' => 'Berhasil menampilkan data metode pembayaran!'
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal menampilkan data bank! Code : ' . $e->getMessage(),
                ]);
        }
    }
    public function get_va_created(Request $request)
    {
        try {
            $notification_body = json_decode($request->getContent(), true);
            $external_id = $notification_body['external_id'];

            $waqf = WaqfTransaction::where('reference_code', $external_id)->first();
            if($waqf!=null){
                $user = Waqif::where('user_id', $waqf->user_id)->first();
                $notif_title = 'Selesaikan pembayaran Anda';
                $notif_desc = 'Mohon lunasi pembayaran agar dapat masuk ke dompet wakaf';
                create_firebase_notif($user->fcm_token, $notif_title, $notif_desc);
                create_notification_data($user->id, 0, $notif_title, $notif_desc);

                return response()
                    ->json([
                        'success' => true,
                        'message' => 'Sukses membuat pembayaran!',
                    ]);
            } else {
                return response()
                    ->json([
                        'success' => false,
                        'message' => 'Gagal membuat pembayaran! data order tidak ditemukan',
                    ]);
            }

        } catch (\Exception $exception) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal membuat pembayaran!',
                ]);
        }

    }
    public function get_va_response(Request $request)
    {
        try {
            $notification_body = json_decode($request->getContent(), true);
            $external_id = $notification_body['external_id'];

            $waqf = WaqfTransaction::where('reference_code', $external_id)->first();
            $program = Program::where('id', $waqf->program_id)->first();
            if($waqf!=null){
                $user = Waqif::where('user_id', $waqf->user_id)->first();
                $notif_title = 'Selesaikan pembayaran Anda';
                $notif_desc = 'Mohon lunasi pembayaran agar dapat masuk ke dompet wakaf';
                create_firebase_notif($user->fcm_token, $notif_title, $notif_desc);
                create_notification_data($user->id, 0, $notif_title, $notif_desc);
                $tokens = get_all_admintokens();
                create_mass_firebase_notif($tokens, 'Halo, ada pembayaran wakaf masuk', 'Dana sebesar '.$waqf->amount.' telah masuk ke program '.$program->title);
                $waqf->update(['status'=> 1]);
                $waqf->update(['paid_at'=> Carbon::now()]);
                $program->update(['terkumpul' => $program->terkumpul+$waqf->amount]);
                return response()
                    ->json([
                        'success' => true,
                        'message' => 'Sukses update pembayaran!',
                    ]);
            } else {
                return response()
                    ->json([
                        'success' => false,
                        'message' => 'Gagal update pembayaran! data order tidak ditemukan',
                    ]);
            }

        } catch (\Exception $exception) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal membuat pembayaran! err : '.$exception->getMessage().'di line '.$exception->getLine(),
                ]);
        }

    }
}