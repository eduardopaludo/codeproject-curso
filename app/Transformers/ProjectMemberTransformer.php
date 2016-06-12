<?php
/**
 * Created by PhpStorm.
 * User: eduar
 * Date: 6/11/2016
 * Time: 1:46 AM
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\User;
use League\Fractal\TransformerAbstract;
class ProjectMemberTransformer extends TransformerAbstract
{
    public function transform(User $member)
    {
        return [
            'member_id' => $member->id,
            'name' => $member->name
        ];
    }
}