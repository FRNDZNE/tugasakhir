<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class LogbookImage extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'logbook_images';
    protected $guarded = [];

    public function logbook()
    {
        return $this->belongsTo(Logbook::class);
    }

}
