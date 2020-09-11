<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /* Fillable */
    protected $fillable = [
        'name', 'email', 'seeker_profile_id'
    ];

    public function messages()
    {
        return $this->hasMany(ContactMessage::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = strtolower($model->name);
            $model->email = strtolower($model->email);
        });
        static::updating(function ($model) {
            $model->name = strtolower($model->name);
            $model->email = strtolower($model->email);
        });
    }
}
