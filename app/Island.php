<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Island extends Model
{
    protected $fillable = [
        'name', 'code',
    ];

    public $sortable = [
        'name', 'code',
    ];

    public function squares()
    {
        return $this->hasMany(Square::class);
    }

    public function nameSortable($query, $direction)
    {
        return $query->orderByRaw("ISNULL(name), name $direction");
    }

    public function codeSortable($query, $direction)
    {
        return $query->orderByRaw("ISNULL(code), code $direction");
    }
}
