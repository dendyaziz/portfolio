<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SquareSkin extends Model
{
    protected $fillable = [
        'square_id', 'skin_id', 'image_id'
    ];

    public function square()
    {
        return $this->belongsTo(Square::class);
    }

    public function skin()
    {
        return $this->belongsTo(Skin::class);
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($squareSkin) {
            $squareSkin->created_by = auth()->user()->id;
        });
        static::updating(function ($squareSkin) {
            $squareSkin->updated_by = auth()->user()->id;
        });
    }
}
