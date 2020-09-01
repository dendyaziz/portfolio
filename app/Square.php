<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Traits\Searchable;

class Square extends Model
{
    use Sortable;
    use Searchable;

    protected $fillable = [
        'type', 'color', 'star', 'island_id'
    ];

    public $sortable = [
        'id', 'type', 'color', 'island_id', 'getStar', 'loseStar'
    ];

    public $searchable = [
        'id', 'type', 'color', 'getStar'
    ];

    public function squareSkins()
    {
        return $this->hasMany(SquareSkin::class);
    }

    public function island()
    {
        return $this->belongsTo(Island::class);
    }

    public function getIsStartAttribute()
    {
        return $this->type === 'start';
    }

    public function getIsSwitchAttribute()
    {
        return $this->type === 'arrow';
    }

    public function colorSortable($query, $direction)
    {
        return $query->orderByRaw("ISNULL(color), color $direction");
    }

    public function getStarSortable($query, $direction)
    {
        return $query->orderByRaw("star = 0, star < 0, star $direction");
    }

    public function loseStarSortable($query, $direction)
    {
        $direction = $direction === 'asc' ? 'desc' : 'asc';
        return $query->orderByRaw("star = 0, star > 0, star $direction");
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($square) {
            $square->created_by = auth()->user()->id;
        });
        static::updating(function ($square) {
            $square->updated_by = auth()->user()->id;
        });
    }
}
