<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Program;
use App\Models\WaqfTransaction;
use App\Models\Waqif;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Xendit\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $organization = null;
        $total_programs = Program::count();
        $total_waqif = Waqif::count();
        $lembaga_count = Organization::count();
        $total_transactions = WaqfTransaction::where('status', 1)->sum('amount');
        if (Auth::user()->role_id != 1) {
            $organization = Organization::with('user')
                ->where('user_id', Auth::id())->first();
        }
        return Inertia::render('Dashboard/Index', [
            'total_program' => $total_programs,
            'total_waqif' => $total_waqif,
            'total_lembaga'=> $lembaga_count,
            'total_transaction' => $total_transactions,
            'organization' => $organization
        ]);
    }
}
