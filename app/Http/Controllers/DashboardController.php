<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $organization = null;
        if(Auth::user()->role_id!=1){
            $organization = Organization::with('user')
                ->where('user_id', Auth::id())->first();
        }
        return Inertia::render('Dashboard/Index', [
            'organization' => $organization
        ]);
    }
}
