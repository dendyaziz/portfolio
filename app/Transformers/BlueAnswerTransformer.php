<?php

namespace App\Transformers;

use App\BlueAnswer;
use League\Fractal\TransformerAbstract;

class BlueAnswerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param BlueAnswer $model
     * @return array
     */
    public function transform(BlueAnswer $model)
    {
        return [
            'id' => $model->id,
            'image_url' => $model->image->compressedUrl,
            'thumbnail_image_url' => $model->image->thumbnailUrl,
            'is_correct' => (boolean) $model->is_correct
        ];
    }
}
