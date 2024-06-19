<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class ScoreValue extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'score_values';
    protected $guarded = [];

    public function score()
    {
        return $this->belongsTo(Score::class);
    }

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
