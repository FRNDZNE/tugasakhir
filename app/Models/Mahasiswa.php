<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Mahasiswa extends Model
{
    use HasFactory, SoftDeletes;
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

    public function accepted()
    {
        return $this->intern()->where('status', 'a');
    }

    public function process()
    {
        return $this->intern()->where('status', 'p');
    }

}
