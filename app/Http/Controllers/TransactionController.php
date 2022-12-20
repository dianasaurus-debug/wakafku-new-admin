<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\WaqfTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function all_transactions(Request $request)
    {
        $all_transactions = WaqfTransaction::with('payment_method')
            ->with('program')
            ->orderBy('created_at')
            ->get();
        return Inertia::render('Transactions/Index', [
        'filters' => \Illuminate\Support\Facades\Request::all('search'),
        'all_transactions' => $all_transactions,
    ]);
    }


}
