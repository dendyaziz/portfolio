<?php

namespace App\Transformers;

use App\Square;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

class SquareTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Square $model
     * @return array
     */
    public function transform(Square $model)
    {
        $squareSkins = fractal()->collection($model->squareSkins)
            ->transformWith(new SquareSkinTransformer(true, false))
            ->serializeWith(ArraySerializer::class);

        return [
            'id' => $model->id,
            'type' => $model->type,
            'color' => $model->color,
            'get_star' => $model->star > 0 ? $model->star : '',
            'lose_star' => $model->star < 0 ? -$model->star : '',
            'name' => $model->island ? $model->island->name : '',
            'code' => $model->island ? $model->island->code : '',
            'square_skins' => $squareSkins,
        ];
    }
}
