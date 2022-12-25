<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Waqif;
use App\Notifications\SendOTPCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')],
            'password' => ['nullable'],
        ]);

        if($validator->fails()){
            $email = $request['email'];
            $user = Waqif::whereHas('user', function($q) use($email){
                $q->where('email', $email);
            })->with('user')->first();
            if($user){
                if($user->is_verified==null){
                    $user->update(['otp_code' => rand(100000, 999999)]);
                    $user->update(['otp_expires_at' => Carbon::now()->addMinutes(10)]);
                    $user->notify(new SendOTPCode());
                    $data = [
                        'success' => true,
                        'is_verified' => false,
                        'user' => $user,
                        'message' => 'Mohon verifikasi E-Mail Anda terlebih dahulu',
                    ];
                    return response()->json($data);
                } else {
                    $data = [
                        'success' => false,
                        'is_verified' => true,
                        'message' => 'Akun sudah ada',
                    ];
                    return response()->json($data);
                }
            }
        }
        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2,
            ]);
            $waqif = Waqif::create([
                'user_id' => $user->id
            ]);
            $waqif_with_user = Waqif::where('id', $waqif->id)->with('user')->first();
            $waqif_with_user->update(['otp_code' => rand(100000, 999999)]);
            $waqif_with_user->update(['otp_expires_at' => Carbon::now()->addMinutes(10)]);
            $waqif_with_user->notify(new SendOTPCode());

            $data = [
                'success' => true,
                'user' => $waqif_with_user,
                'is_verified' => false,
                'message' => 'Mohon cek email Anda untuk kode OTP',
            ];
        } catch (\Exception $exception){
            $data = [
                'success' => false,
                'is_verified' => false,
                'message' => 'Terdapat eror! '.$exception->getMessage(),
            ];
        }

        return response()->json($data);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['success' => false,'message' => 'E-Mail atau Password Anda salah'], 401);
        }
        try {
            $user = User::where('email', $request['email'])
                ->where('role_id', 2)
                ->with('waqif')
                ->first();
            $waqif = Waqif::where('user_id', $user->id)->with('user')->first();
            if($user->waqif->is_verified == null){
                $waqif->update(['otp_code' => rand(100000, 999999)]);
                $waqif->update(['otp_expires_at' => Carbon::now()->addMinutes(10)]);
                $waqif->notify(new SendOTPCode());
                return response()
                    ->json([
                        'success' => false,
                        'is_verified' => false,
                        'message' => 'Mohon verifikasi E-Mail Anda terlebih dahulu!',
                        'user' => $waqif
                    ]);

            } else {
                $token = $user->createToken('auth_token')->plainTextToken;
                $waqif->update(['fcm_token' => $request->fcm_token]);

                return response()
                    ->json([
                        'success' => true,
                        'message' => 'Berhasil login!',
                        'data' => $user,
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                    ]);
            }

        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal login! Error : '.$e->getMessage().' in line '.$e->getLine(),
                ]);
        }
    }
    // method for user logout and delete token
    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil logout!',
                ]);
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal logout! Error : '.$e->getMessage(),
                ]);
        }
    }

    public function verify_otp(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'kode_otp' => ['required'],
        ]);

        if($validator->fails()){
            $data = [
                'success' => false,
                'message' => 'Kode OTP tidak boleh kosong!',
            ];
            return response()->json($data);
        }
        try {
            $otp = $request->kode_otp;
            $waqif = Waqif::where('otp_code', $request->kode_otp)->whereNull('is_verified')->with('user')->first();

            if($waqif)
            {
                $user = User::where('id', $waqif->user_id)->first();
                if(Carbon::parse($waqif->otp_expires_at)->format('Y-m-d H:i:s')<Carbon::now()->format('Y-m-d H:i:s')){
                    return response()
                        ->json([
                            'success' => false,
                            'is_verified' => false,
                            'times_up' => true,
                            'now' => Carbon::parse($waqif->otp_expires_at)->format('Y-m-d H:i:s'),
                            'message' => 'Kode OTP sudah kadaluarsa',
                        ]);
                } else {
                    $waqif->resetOTP();
                    $waqif->update(['is_verified' => 1]);
                    $token = $user->createToken('auth_token')->plainTextToken;
                    return response()
                        ->json([
                            'success' => true,
                            'is_verified' => true,
                            'times_up' => false,
                            'message' => 'Akun berhasil diverifikasi!',
                            'access_token' => $token,
                            'token_type' => 'Bearer',
                        ]);
                }
            } else {
                return response()
                    ->json([
                        'success' => false,
                        'is_verified' => false,
                        'times_up' => false,
                        'message' => 'Kode OTP salah!',
                    ]);
            }
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'is_verified' => false,
                    'times_up' => false,
                    'message' => 'Terdapat kesalahan! : '.$e->getMessage(),
                ]);
        }
    }

    public function resend(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => ['required'],
        ]);

        if($validator->fails()){
            $data = [
                'success' => false,
                'message' => 'E-Mail tidak boleh kosong!',
            ];
            return response()->json($data);
        }
        try {
            $waqif = Waqif::whereHas('user', function($q) use($request){
                $q->where('email', $request->email);
                $q->whereNull('is_verified');
            })->first();
            if($waqif)
            {
                $user = User::where('id', $waqif->user_id)->first();
                $waqif->generateOTP();
                $waqif->notify(new SendOTPCode());
                return response()
                    ->json([
                        'success' => true,
                        'message' => 'Kode OTP sudah dikirim ulang!',
                    ]);
            }
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Terdapat eror! '.$e->getMessage(),
                ]);
        }

    }

    public function profile(Request $request){
        if(!auth()){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ]);
        }
        try {
            $waqif = Waqif::where('user_id', auth()->user()->id)->with('user')->first();
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil menampilkan profil!',
                    'data' => $waqif
                ]);
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal menampilkan profil! Error : '.$e->getMessage(),
                ]);
        }
    }
//    public function update(Request $request)
//    {
//        $validator = Validator::make($request->all(),[
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|max:255',
//            'phone' => 'required|string',
//        ]);
//
//        if($validator->fails()){
//            return response()
//                ->json(['success' => false,'message' => 'Pastikan data dimasukkan dengan lengkap!'], 401);
//        }
//
//        try {
//            $user = User::where('id', auth()->user()->id)->first();
//            if($request->hasfile('photo')) {
//                $old_photo = public_path('/images/uploads/'.$user->profile_photo_path);
//                if(File::exists($old_photo)) {
//                    File::delete($old_photo);
//                }
//                if ($request->file('photo')) {
//                    $user->update(['photo_path' => $request->file('photo')->store('users')]);
//                }
//                $user->update([
//                    'first_name' => $request->first_name,
//                    'email' => $request->email,
//                    'last_name' => $request->last_name,
//                    'phone' => $request->phone,
//                ]);
//
//            } else {
//                $user->update([
//                    'email' => $request->email,
//                    'first_name' => $request->first_name,
//                    'last_name' => $request->last_name,
//                    'phone' => $request->phone,
//                ]);
//            }
//
//            return response()
//                ->json([
//                    'success' => true,
//                    'message' => 'Berhasil update profil!',
//                    'data' => $user
//                ]);
//        } catch (\Exception $e){
//            return response()
//                ->json([
//                    'success' => false,
//                    'message' => 'Gagal update profil! Error : '.$e->getMessage(),
//                ]);
//        }
//    }
    public function change_password(Request $request){
        if(!auth()){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ]);
        }
        try {
            $user = auth()->user();
            if(Hash::check($request->password, $user->password)){
                $found_user = User::where('id', $user->id)->first();
                $found_user->update(['password'=>Hash::make($request->new_password)]);
                return response()
                    ->json([
                        'success' => true,
                        'message' => 'Berhasil merubah password!',
                        'data' => $user
                    ]);
            } else {
                return response()
                    ->json([
                        'success' => false,
                        'message' => 'Password yang dimasukkan tidak tepat',
                    ]);
            }

        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal menampilkan profil! Error : '.$e->getMessage(),
                ]);
        }
    }
}
