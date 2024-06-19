<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Year extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'years';
    protected $guarded = [];

    public function period()
    {
        return $this->hasMany(Period::class);
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
