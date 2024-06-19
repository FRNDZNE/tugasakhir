<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Prodi extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'prodis';
    protected $guarded = [];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function dosen()
    {
        return $this->belongsToMany(Dosen::class);
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function period()
    {
        return $this->hasMany(Period::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function score()
    {
        return $this->hasMany(Score::class);
    }
}
