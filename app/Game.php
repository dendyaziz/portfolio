<?php

namespace App;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Game extends Model
{
    use Sortable;
    use Searchable;

    protected $fillable = [
        'skin_id', 'board_id', 'room_master_id', 'room_name', 'password', 'max_player'
    ];

    public $sortable = [
        'id'
    ];

    public $searchable = [
        'id'
    ];

    public function roomMaster()
    {
        return $this->belongsTo(PlayerProfile::class, 'room_master_id');
    }
}
