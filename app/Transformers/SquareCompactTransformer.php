<?php

namespace App\Transformers;

use App\Square;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

class SquareCompactTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Square $model
     * @return array
     */
    public function transform(Square $model)
    {
        $squareSkins = $model->squareSkins;
        $squareSkin = count($squareSkins) > 0 ? $squareSkins[0] : '';

        return [
            'id' => $model->id,
            'type' => $model->type,
            'name' => $model->island ? $model->island->name : '',
            'code' => $model->island ? $model->island->code : '',
            'image_url' => $squareSkin ? $squareSkin->image->compressedUrl : '',
            'thumbnail_image_url' => $squareSkin ? $squareSkin->image->thumbnailUrl : '',
        ];
    }
}
