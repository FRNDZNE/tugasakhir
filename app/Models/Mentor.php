<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Mentor extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'mentors';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function intern()
    {
        return $this->hasMany(Intern::class);
    }

    
}
