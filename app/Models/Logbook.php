<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;


class Logbook extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'logbooks';
    protected $guarded = [];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }

    public function image()
    {
        return $this->hasMany(LogbookImage::class);
    }

}
