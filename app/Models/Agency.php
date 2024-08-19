<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Agency extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'agencies';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function intern()
    {
        return $this->hasMany(Intern::class);
    }

    public function quota()
    {
        return $this->hasMany(Quota::class);
    }

    public function mentor()
    {
        return $this->hasMany(Mentor::class);
    }


}
