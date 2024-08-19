<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Dosen extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'dosens';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsToMany(Prodi::class);
    }

    public function intern()
    {
        return $this->hasMany(Intern::class);
    }


}
