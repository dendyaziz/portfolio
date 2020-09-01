<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GamePlayer extends Model
{
    protected $fillable = [
      'game_id', 'user_id', 'color', 'total_point',
    ];
}
