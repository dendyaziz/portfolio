<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlueQuestion extends Model
{
    protected $fillable = [
        'audio_id', 'audio_text'
    ];

    public function question()
    {
        return $this->morphOne(Question::class, 'questionable');
    }

    public function audio()
    {
        return $this->hasOne(File::class, 'id', 'audio_id');
    }

    public function options()
    {
        return $this->hasMany(BlueAnswer::class);
    }

    public function answer()
    {
        return $this->hasOne(BlueAnswer::class)->where('is_correct', true);
    }
}
