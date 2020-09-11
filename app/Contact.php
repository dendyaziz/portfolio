<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Message;

class Contact extends Model
{
    /* Fillable */
    protected $fillable = [
        'name', 'email', 'seeker_profile_id'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
