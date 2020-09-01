<?php

namespace App\Transformers;

use App\BlueQuestion;
use League\Fractal\TransformerAbstract;

class BlueQuestionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param BlueQuestion $model
     * @return array
     */
    public function transform(BlueQuestion $model)
    {
        return [
            'id' => $model->id,
            'audio_text' => $model->audio_text ?? null,
            'audio_url' => $model->audio->url,
        ];
    }
}
