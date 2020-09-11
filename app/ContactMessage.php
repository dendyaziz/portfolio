<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    /* Fillable */
    protected $fillable = [
        'contact_id', 'message',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
