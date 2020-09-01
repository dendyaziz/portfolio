<?php

namespace App\Transformers;

use App\PlayerProfile;
use League\Fractal\TransformerAbstract;

class PlayerProfileTransformer extends TransformerAbstract
{
    private $hasUser;

    public function __construct($hasUser = true)
    {
        $this->hasUser = $hasUser;
    }

    /**
     * A Fractal transformer.
     *
     * @param PlayerProfile $model
     * @return array
     */
    public function transform(PlayerProfile $model)
    {
        return [
            'name' => $model->user->name,
            'username' => $model->user->username,
        ];
    }
}
