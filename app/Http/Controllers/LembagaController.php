<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Program;
use App\Models\User;
use App\Notifications\ApproveOrganization;
use App\Notifications\RejectOrganization;
use App\Notifications\SendOTPCode;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LembagaController extends Controller
{
    public function index()
    {
        return Inertia::render('Lembaga/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search'),
            'organizations' => Organization::with('user')
                ->with('address')
                ->get()
        ]);
    }
    public function detail($id)
    {
        $lembaga = Organization::with('user')
            ->with('address')
            ->with('file')
            ->where('id', $id)->first();
        return Inertia::render('Lembaga/Detail', [
            'lembaga' => $lembaga
        ]);
    }
    public function edit($id)
    {
        $lembaga = Organization::with('user')
            ->with('address')
            ->with('file')
            ->where('id', $id)->first();
        return Inertia::render('Lembaga/Edit', [
            'lembaga' => $lembaga
        ]);
    }
    public function approved($id)
    {
        try {
            $lembaga = Organization::with('user')
                ->with('address')
                ->with('file')
                ->where('id', $id)->first();
            $lembaga->update(['status' => 'approved']);
            $user = User::where('id', $lembaga->user_id)->first();
            $user->update(['status' => 'approved']);
            $lembaga->user->notify(new ApproveOrganization($lembaga));
            $data = [
                'success' => true,
                'message' => 'Lembaga berhasil disetujui',
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            $data = [
                'success' => false,
                'message' => 'Lembaga gagal disetujui! err'.$e->getMessage()
            ];
            return response()->json($data);
        }

    }
    public function reject($id)
    {
        try {
            $lembaga = Organization::with('user')
                ->with('address')
                ->with('file')
                ->where('id', $id)->first();
            $lembaga->update(['status' => 'rejected']);
            $user = User::where('id', $lembaga->user_id)->first();
            $user->update(['status' => 'rejected']);
            $lembaga->user->notify(new RejectOrganization($lembaga));
            $data = [
                'success' => true,
                'message' => 'Lembaga berhasil ditolak',
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            $data = [
                'success' => false,
                'message' => 'Lembaga gagal ditolak! err'.$e->getMessage()
            ];
            return response()->json($data);
        }
    }

}
