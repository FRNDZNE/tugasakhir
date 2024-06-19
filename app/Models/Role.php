<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Role extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'roles';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
