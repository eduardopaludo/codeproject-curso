<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\User;

/**
 * Class ProjectOwnerTransformer
 * @package namespace CodeProject\Transformers;
 */
class ProjectOwnerTransformer extends TransformerAbstract
{

    /**
     * Transform the \User entity
     * @param \User $model
     *
     * @return array
     */
    public function transform(User $model) {
        return [
            'owner_id'     =>  $model->id,
            'owner'        =>  $model->name,
            'email'         =>  $model->email,
            'created_at'    =>  $model->created_at->toDateTimeString(),
            'updated_at'    =>  $model->updated_at->toDateTimeString(),
        ];
    }
}