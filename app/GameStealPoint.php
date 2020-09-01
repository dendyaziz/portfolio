<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameStealPoint extends Model
{
    protected $fillable = [
        'game_movement_id', 'target_player_id', 'lose_point_id',
    ];
}
