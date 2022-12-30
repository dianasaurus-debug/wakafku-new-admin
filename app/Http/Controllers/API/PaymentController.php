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
    public function create_transaction(Request $request)
    {
        try {

            $wakif = Waqif::where('user_id', Auth::id())->with('user')->first();
            $payment_method_data = PaymentMethod::where('label', $request->channel)->first();
            if ($payment_method_data->kind == 'va') {
                $createVA = make_bank_payment($payment_method_data->label, $request->nominal);
            } else if ($payment_method_data->kind == 'retail') {
                $createVA = make_retail_payment($payment_method_data->label, intval($request->nominal));
            }
            $ref_id = 'wakafku-ewallet-'.time();

            $transaction = WaqfTransaction::create([
                'payment_due' => Carbon::parse(Carbon::now())->addHours(12),
                'reference_code' => isset($createVA) && $payment_method_data != 'ewallet' ? $createVA[config('__constant.EXTERNAL_IDS')[$payment_method_data->kind]] : $ref_id,
                'payment_code' => isset($createVA) && $payment_method_data != 'ewallet' ? $createVA[config('__constant.PAYMENT_CODES')[$payment_method_data->kind]] : $ref_id,
                'amount' => $request->nominal,
                'payment_method_id' => $payment_method_data->id,
                'jenis_wakaf' => $request->jenis,
                'atas_nama' => isset($request->atas_nama) ? $request->atas_nama : Auth::user()->name,
                'program_id' => $request->program_id,
                'waqif_id' => $wakif->id,
            ]);
            if ($request->jenis == 'berjangka') {
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
            if ($payment_method_data->kind == 'ewallet') {
                $ref_id = 'wakafku-ewallet-'.time().$transaction_data->id;
                $intended_link = config('__constant.FCM_URL_TEST');
                $phone_number = isset($request->phone_number) ? $request->phone_number : $wakif->phone;
                $short_url = create_short_link($intended_link . '/payment?id=' . $transaction_data->id . '&is_failed=false');
                $channel_property = $request->channel == 'ID_OVO' ? $phone_number : $short_url;
                $object_va = make_ewallet_payment($channel_property, $request->channel, $request->nominal, $ref_id);
            }
            $payment_link = null;
            if($object_va){
                if (isset($object_va['actions'])) {
                    if ($request->channel == 'ID_SHOPEEPAY') {
                        $payment_link = $object_va['actions']['mobile_deeplink_checkout_url'];

                    } else {
                        $payment_link = $object_va['actions']['mobile_web_checkout_url'];
                    }
                }
                $transaction_data->update(['reference_code' => $object_va[config('__constant.EXTERNAL_IDS')[$payment_method_data->kind]] ]);
                $transaction_data->update(['payment_code' => $object_va[config('__constant.PAYMENT_CODES')[$payment_method_data->kind]].time().$transaction_data->id ]);

            } else {
                return response()
                    ->json([
                        'success' => false,
                        'message' => 'Gagal membuat data pembayaran',
                        'data' => $transaction_data
                    ]);

            }

            return response()
                ->json([
                    'success' => true,
                    'payment_link' => $payment_link,
                    'message' => 'Berhasil membuat data pembayaran',
                    'data' => $transaction_data
                ]);


        } catch (\Exception $exception) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan message : ' . $exception->getMessage() . ' di line ' . $exception->getLine(),
                ]);
        }

    }

    public function bank_list(Request $request)
    {
        try {
            $ewallet = DB::table('payment_methods')
                ->where('is_activated', true)
                ->where('kind', 'ewallet')
                ->get();
            $va = DB::table('payment_methods')
                ->where('is_activated', true)
                ->where('kind', 'va')
                ->get();
            $retail = DB::table('payment_methods')
                ->where('is_activated', true)
                ->where('kind', 'retail')
                ->get();
            return response()
                ->json([
                    'success' => true,
                    'data' => [
                        'ewallet' => $ewallet,
                        'va' => $va,
                        'retail' => $retail,
                    ],
                    'message' => 'Berhasil menampilkan data bank!'
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
            if ($waqf != null) {
                $user = Waqif::where('id', $waqf->waqif_id)->first();
                $notif_title = 'Selesaikan pembayaran Anda';
                $notif_desc = 'Mohon lunasi pembayaran agar dapat masuk ke dompet wakaf';
                create_firebase_notif($user->fcm_token, $notif_title, $notif_desc);
                create_notification_data($user->id, 'pembayaran', $notif_title, $notif_desc);

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
        $notification_body = json_decode($request->getContent(), true);

        $external_id = $notification_body['external_id'];
        $waqf = WaqfTransaction::where('reference_code', $external_id)->first();
        try {

            $program = Program::where('id', $waqf->program_id)->first();
            $user = Waqif::where('id', $waqf->waqif_id)->first();
            if ($waqf != null) {
                $notif_title = 'Pembayaran Anda sudah lunas';
                $notif_desc = 'Terima kasih pembayaran Anda sudah masuk ke dompet wakaf';
                create_firebase_notif($user->fcm_token, $notif_title, $notif_desc);
                create_notification_data($user->id, 'pembayaran', $notif_title, $notif_desc);
                $tokens = get_all_admintokens();
                create_mass_firebase_notif($tokens, 'Halo, ada pembayaran wakaf masuk', 'Dana sebesar ' . $waqf->amount . ' telah masuk ke program ' . $program->title);
                $waqf->update(['status' => 1]);
                $waqf->update(['paid_at' => Carbon::now()]);
                $program->update(['terkumpul' => $program->terkumpul + $waqf->amount]);
                $precentage = 0;
                if($program->target!=0){
                    $precentage = $program->terkumpul != 0 ? ($program->terkumpul/$program->target) * 100 : 0;
                }
                $program->update(['percentage' => $precentage]);
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
                    'data' => $user,
                    'message' => 'Gagal membuat pembayaran! err : ' . $exception->getMessage() . 'di line ' . $exception->getLine(),
                ]);
        }

    }
    public function get_ewallet_response(Request $request)
    {
        $notification_body = json_decode($request->getContent(), true);

        $external_id = $notification_body['data']['reference_id'];
        $waqf = WaqfTransaction::where('reference_code', $external_id)->first();
        try {
            if ($waqf != null) {
                $program = Program::where('id', $waqf->program_id)->first();
                $user = Waqif::where('id', $waqf->waqif_id)->first();
                $notif_title = 'Pembayaran Anda sudah lunas';
                $notif_desc = 'Terima kasih pembayaran Anda sudah masuk ke dompet wakaf';
                create_firebase_notif($user->fcm_token, $notif_title, $notif_desc);
                create_notification_data($user->id, 'pembayaran', $notif_title, $notif_desc);
                $tokens = get_all_admintokens();
                create_mass_firebase_notif($tokens, 'Halo, ada pembayaran wakaf masuk', 'Dana sebesar ' . $waqf->amount . ' telah masuk ke program ' . $program->title);
                $waqf->update(['status' => 1]);
                $waqf->update(['paid_at' => Carbon::now()]);
                $program->update(['terkumpul' => $program->terkumpul + $waqf->amount]);
                $precentage = 0;
                if($program->target!=0){
                    $precentage = $program->terkumpul != 0 ? ($program->terkumpul/$program->target) * 100 : 0;
                }
                $program->update(['percentage' => $precentage]);
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
                    'message' => 'Gagal membuat pembayaran! err : ' . $exception->getMessage() . 'di line ' . $exception->getLine(),
                ]);
        }

    }


}
