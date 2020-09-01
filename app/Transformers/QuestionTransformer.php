<?php

namespace App\Transformers;

use App\Question;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

class QuestionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Question $model
     * @return array
     */
    public function transform(Question $model)
    {
        $questionable = $model->questionable;

        if ($model->isBlue) {
            $question = fractal()->item($questionable)
                ->transformWith(new BlueQuestionTransformer())
                ->serializeWith(ArraySerializer::class);

            $options = fractal()->collection($questionable->options)
                ->transformWith(new BlueAnswerTransformer())
                ->serializeWith(ArraySerializer::class);

            $answer = fractal()->item($questionable->answer)
                ->transformWith(new BlueAnswerTransformer())
                ->serializeWith(ArraySerializer::class);
        } else {
            $question = fractal()->item($questionable)
                ->transformWith(new BlueQuestionTransformer())
                ->serializeWith(ArraySerializer::class);

            $options = fractal()->collection($questionable->options)
                ->transformWith(new BlueAnswerTransformer())
                ->serializeWith(ArraySerializer::class);

            $answer = fractal()->item($questionable->answer)
                ->transformWith(new BlueAnswerTransformer())
                ->serializeWith(ArraySerializer::class);
        }

        return [
            'id' => $model->id,
            'difficulty' => $model->difficulty,
            'color' => $model->color,
            'question' => $question,
            'options' => $options,
            'answer' => $answer,
        ];
    }
}
