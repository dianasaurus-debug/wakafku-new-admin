<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReminder extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
    public function transaction()
    {
        return $this->hasOne(WaqfTransaction::class, 'id', 'transaction_id')
            ->with('payment_method')
            ->with('program');
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
}
