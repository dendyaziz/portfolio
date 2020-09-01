<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameQuestion extends Model
{
    protected $fillable = [
        'game_movement_id', 'question_id', 'answerable_type', 'answerable_id', 'other_answer', 'is_correct',
    ];
}
