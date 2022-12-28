<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Models\Waqif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function all_notifications(Request $request)
    {
        try {
            $user = Waqif::where('user_id', Auth::id())->first();
            $all_notifications = Notification::where('user_id', $user->id)->latest('id')->get();
            $data = array(
                'status' => 'success',
                'message' => 'Berhasil menampilkan data transaksi',
                'data' => $all_notifications,
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
