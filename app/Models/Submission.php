<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;


class Submission extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'submissions';
    protected $guarded = [];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
