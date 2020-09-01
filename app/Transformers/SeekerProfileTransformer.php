<?php

namespace App\Transformers;

use App\SeekerProfile;
use League\Fractal\TransformerAbstract;

class SeekerProfileTransformer extends TransformerAbstract
{
    private $hasUser;

    public function __construct($hasUser = true)
    {
        $this->hasUser = $hasUser;
    }

    /**
     * A Fractal transformer.
     *
     * @param SeekerProfile $model
     * @return array
     */
    public function transform(SeekerProfile $model)
    {
        return [
            'name' => $model->user->name,
            'username' => $model->user->username,
        ];
    }
}
