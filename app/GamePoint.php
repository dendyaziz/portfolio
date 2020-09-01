<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GamePoint extends Model
{
    protected $fillable = [
        'game_id', 'player_id', 'point'
    ];
}
