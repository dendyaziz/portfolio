<?php

namespace App\Transformers;

use App\Skin;
use League\Fractal\TransformerAbstract;

class SkinTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Skin $model
     * @return array
     */
    public function transform(Skin $model)
    {
        return [
            'id' => $model->id,
        ];
    }
}
