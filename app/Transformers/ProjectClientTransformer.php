<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\Client;

/**
 * Class ProjectClientTransformer
 * @package namespace CodeProject\Transformers;
 */
class ProjectClientTransformer extends TransformerAbstract
{

    /**
     * Transform the \Client entity
     * @param \Client $model
     *
     * @return array
     */
    public function transform(Client $model) {
        return [
            'client_id'     =>  $model->id,
            'client'        =>  $model->name,
            'responsible'   =>  $model->responsible,
            'address'       =>  $model->address,
            'email'         =>  $model->email,
            'phone'         =>  $model->phone,
            'obs'           =>  $model->obs,
            'created_at'    =>  $model->created_at->toDateTimeString(),
            'updated_at'    =>  $model->updated_at->toDateTimeString(),
        ];


    }
}