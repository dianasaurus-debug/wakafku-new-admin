<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaqfTransaction extends Model
{
    use HasFactory;
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
    public function waqif()
    {
        return $this->belongsTo(Waqif::class, 'waqif_id', 'id')->with('user');
    }
    public function berjangka_data()
    {
        return $this->hasOne(WaqfReturn::class, 'waqf_id', 'id');
    }
}
