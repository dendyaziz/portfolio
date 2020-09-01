<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlueAnswer extends Model
{
    protected $fillable = [
        'blue_question_id', 'image_id', 'is_correct'
    ];

    public function blueQuestion()
    {
        return $this->belongsTo(BlueQuestion::class);
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public static function boot()
    {
        parent::boot();
        static::updating(function ($blueAnswer) {
            $blueAnswer->updated_by = auth()->user()->id;
        });
    }
}
