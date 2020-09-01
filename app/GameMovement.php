<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameMovement extends Model
{
    protected $fillable = [
        'game_id', 'step_id', 'player_id', 'point_id', 'die_number',
    ];
}
