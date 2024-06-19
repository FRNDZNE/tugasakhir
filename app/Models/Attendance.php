<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;


class Attendance extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'attendances';
    protected $guarded = [];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
