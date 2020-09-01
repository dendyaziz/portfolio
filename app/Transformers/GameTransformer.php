<?php

namespace App\Transformers;

use App\Game;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

class GameTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Game $model
     * @return array
     */
    public function transform(Game $model)
    {
        $roomMaster = fractal()->item($model->roomMaster)
            ->transformWith(new PlayerProfileTransformer())
            ->serializeWith(ArraySerializer::class);

        return [
            'id' => $model->id,
            'skin_id' => $model->skin_id,
            'board_id' => $model->board_id,
            'max_player' => $model->max_player,
            'room_master' => $roomMaster,
        ];
    }
}
