<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'scores';
    protected $guarded = [];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function value()
    {
        return $this->hasMany(ScoreValue::class);
    }

}
