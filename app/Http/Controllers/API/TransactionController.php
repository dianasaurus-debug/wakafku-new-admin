<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WaqfTransaction;
use App\Models\Waqif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function all_transactions(Request $request)
    {
        try {
            $user = Waqif::where('user_id', Auth::id())->first();
            $all_transactions = WaqfTransaction::with('payment_method')
                ->where('waqif_id', $user->id)
                ->with('program')
                ->orderBy('created_at')
                ->get();
            $data = array(
                'status' => 'success',
                'message' => 'Berhasil menampilkan data transaksi',
                'data' => $all_transactions,
            );
            return response()->json($data);
        } catch (\Exception $exception) {
            $data = array(
                [
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan : ' . $exception->getMessage()
                ]
            );
            return response()->json($data);
        }
    }

}
