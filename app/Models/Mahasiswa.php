<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;


class Mahasiswa extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'mahasiswas';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function intern()
    {
        return $this->hasOne(Intern::class);
    }

}
