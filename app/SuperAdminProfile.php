<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuperAdminProfile extends Model
{
    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }
}
