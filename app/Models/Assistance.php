<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;


class Assistance extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'assistances';
    protected $guarded = [];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
