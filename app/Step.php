<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Traits\Searchable;

class Step extends Model
{
    use Sortable;
    use Searchable;

    protected $fillable = [
        'board_id', 'square_id', 'next_step_id', 'switch_step_id', 'previous_step_id', 'previous_switch_step_id',
    ];

    public $sortable = [
        'id'
    ];

    public $searchable = [
        'id'
    ];

    public function square()
    {
        return $this->belongsTo(Square::class);
    }

    public function nextStep()
    {
        return $this->belongsTo(Step::class, 'next_step_id');
    }

    public function switchStep()
    {
        return $this->belongsTo(Step::class, 'switch_step_id');
    }

    public function previousStep()
    {
        return $this->belongsTo(Step::class, 'previous_step_id');
    }

    public function previousSwitchStep()
    {
        return $this->belongsTo(Step::class, 'previous_switch_step_id');
    }
}
