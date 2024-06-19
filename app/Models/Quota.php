<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;


class Quota extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'quotas';
    protected $guarded = [];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
