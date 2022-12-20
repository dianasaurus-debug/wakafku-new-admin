<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WaqfTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function all_transactions(Request $request)
    {
        try {
            $all_transactions = WaqfTransaction::with('payment_method')
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
