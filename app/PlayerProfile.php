<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerProfile extends Model
{
    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }
}
