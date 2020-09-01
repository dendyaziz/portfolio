<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeekerProfile extends Model
{
    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }
}
