<?php
/**
 * Created by PhpStorm.
 * User: eduar
 * Date: 5/31/2016
 * Time: 1:06 AM
 */

namespace CodeProject\Repositories;


use CodeProject\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{
    public function model()
    {
        return Client::class;
    }
}