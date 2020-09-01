<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait Searchable
{
    /**
     * @param $query
     */
    public function scopeSearchable($query)
    {
        $model = $this;
        $filter = request()->only($model->searchable);

        foreach ($filter as $key => $value) {
            if(isset($value) && $this->hasColumn($model, $key)) {
                $value = escape_like($value);
                $query->where($key, 'like', '%' . $value . '%');
            }
        }
    }

    /**
     * @param $model
     * @param $column
     *
     * @return bool
     */
    private function hasColumn($model, $column)
    {
        return Schema::connection($model->getConnectionName())->hasColumn($model->getTable(), $column);
    }
}
