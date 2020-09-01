<?php

namespace App\Transformers;

use App\SquareSkin;
use League\Fractal\TransformerAbstract;

class SquareSkinTransformer extends TransformerAbstract
{
    private $includeSkin;
    private $includeSquare;

    public function __construct($includeSkin = true, $includeSquare = true)
    {
        $this->includeSkin = $includeSkin;
        $this->includeSquare = $includeSquare;
    }

    /**
     * A Fractal transformer.
     *
     * @param SquareSkin $model
     * @return array
     */
    public function transform(SquareSkin $model)
    {
        return [
            'id' => $model->id,
            'image_url' => $model->image->compressedUrl,
            'thumbnail_image_url' => $model->image->thumbnailUrl,
        ];
    }
}
