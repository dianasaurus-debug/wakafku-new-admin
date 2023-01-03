<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'organizations';

    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function address()
    {
        return $this->belongsTo(Wilayah::class, 'address_id', 'id');
    }
    public function file()
    {
        return $this->hasOne(OrganizationFile::class, 'organization_id', 'id');
    }
}
