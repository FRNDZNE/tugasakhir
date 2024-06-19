<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Period extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'periods';
    protected $guarded = [];

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function quota()
    {
        return $this->hasMany(Quota::class);
    }

    public function intern()
    {
        return $this->hasMany(Intern::class);
    }
}
