<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'difficulty', 'created_by', 'updated_by'
    ];

    public function questionable()
    {
        return $this->morphTo();
    }

    public function getColorAttribute()
    {
        $morphClass = $this->questionable->getMorphClass();

        if ($morphClass == BlueQuestion::class)
            return 'blue';
        else if ($morphClass == YellowQuestion::class)
            return 'yellow';
        else if ($morphClass == GreenQuestion::class)
            return 'green';
        else
            return 'red';
    }

    public function getIsBlueAttribute()
    {
        return $this->questionable->getMorphClass() == BlueQuestion::class;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($question) {
            $question->created_by = auth()->user()->id;
        });
        static::updating(function ($question) {
            $question->updated_by = auth()->user()->id;
        });
    }
}
