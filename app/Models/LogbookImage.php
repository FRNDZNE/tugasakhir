<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;


class LogbookImage extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'logbook_images';
    protected $guarded = [];

    public function logbook()
    {
        return $this->belongsTo(Logbook::class);
    }

}
