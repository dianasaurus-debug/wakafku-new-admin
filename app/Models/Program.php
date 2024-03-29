<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function address()
    {
        return $this->belongsTo(Wilayah::class, 'address_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id')->with('user');
    }
    public function file()
    {
        return $this->hasOne(ProgramFile::class, 'program_id', 'id');
    }
}
