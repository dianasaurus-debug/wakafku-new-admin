<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Xendit\Transaction;

class Waqif extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function generateOTP()
    {
        $this->timestamps = false;
        $this->otp_code = rand(100000, 999999);
        $this->otp_expires_at = Carbon::now()->addMinutes(10);
        $this->save();
    }

    public function resetOTP()
    {
        $this->timestamps = false;
        $this->otp_code = null;
        $this->otp_expires_at = null;
        $this->save();
    }
    public function routeNotificationForMail($notification)
    {
        return $this->user->email;
    }
    public function transactions()
    {
        return $this->hasMany(WaqfTransaction::class, 'waqif_id', 'id');
    }
}
