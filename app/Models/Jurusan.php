<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Jurusan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'jurusans';
    protected $guarded = [];

    public function admin()
    {
        return $this->hasMany(Admin::class);
    }

    public function prodi()
    {
        return $this->hasMany(Prodi::class);
    }
}
