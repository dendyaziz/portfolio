<?php

namespace App\Transformers;

use App\Step;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

class StepTransformer extends TransformerAbstract
{
    private $hasNextStep;
    private $hasSwitchStep;
    private $hasPreviousStep;
    private $hasPreviousSwitchStep;

    public function __construct($hasNextStep = true, $hasSwitchStep = true, $hasPreviousStep = true, $hasPreviousSwitchStep = true)
    {
        $this->hasNextStep = $hasNextStep;
        $this->hasSwitchStep = $hasSwitchStep;
        $this->hasPreviousStep = $hasPreviousStep;
        $this->hasPreviousSwitchStep = $hasPreviousSwitchStep;
    }

    /**
     * A Fractal transformer.
     *
     * @param Step $model
     * @return array
     */
    public function transform(Step $model)
    {
        if ($model->square) {
            $square = fractal()->item($model->square)
                ->transformWith(new SquareCompactTransformer())
                ->serializeWith(ArraySerializer::class);
        }

        if ($this->hasNextStep && $model->nextStep) {
            $nextStep = fractal()->item($model->nextStep)
                ->transformWith(new StepTransformer(false, false, false))
                ->serializeWith(ArraySerializer::class);
        }

        if ($this->hasSwitchStep && $model->switchStep) {
            $switchStep = fractal()->item($model->switchStep)
                ->transformWith(new StepTransformer(false, false, false))
                ->serializeWith(ArraySerializer::class);
        }

        if ($this->hasPreviousStep && $model->previousStep) {
            $previousStep = fractal()->item($model->previousStep)
                ->transformWith(new StepTransformer(false, false, false))
                ->serializeWith(ArraySerializer::class);
        }

        if ($this->hasPreviousSwitchStep && $model->previousSwitchStep) {
            $previousSwitchStep = fractal()->item($model->previousSwitchStep)
                ->transformWith(new StepTransformer(false, false, false))
                ->serializeWith(ArraySerializer::class);
        }

        return [
            'id' => $model->id,
            'board_id' => $model->board_id,
            'square' => $square ?? null,
            'next_step' => $nextStep ?? null,
            'switch_step' => $switchStep ?? null,
            'previous_step' => $previousStep ?? null,
            'previous_switch_step' => $previousSwitchStep ?? null,
        ];
    }
}
