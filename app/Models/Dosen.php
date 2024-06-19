<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;


class Dosen extends Model
{
    use HasFactory, softDeletes;
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
