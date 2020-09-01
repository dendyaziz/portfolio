<?php

namespace App\Transformers;

use App\Island;
use League\Fractal\TransformerAbstract;

class IslandTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Island $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'code' => $model->code,
        ];
    }
}
