<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;


class Intern extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'interns';
    protected $guarded = [];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function logbook()
    {
        return $this->hasMany(Logbook::class);
    }

    public function assistance()
    {
        return $this->hasMany(Assistance::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function value()
    {
        return $this->hasMany(ScoreValue::class);
    }

}
