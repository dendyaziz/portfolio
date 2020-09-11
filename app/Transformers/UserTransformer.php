<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param User $model
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id' => $model->id,
            'username' => $model->username,
            'name' => $model->name,
            'email' => $model->email,
            'email_verified' => !is_null($model->email_verified_at),
            'profile_id' => $model->profile_id,
            'profile_type' => $model->profile_type,
        ];
    }
}
