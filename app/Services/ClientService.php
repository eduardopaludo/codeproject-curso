<?php
/**
 * Created by PhpStorm.
 * User: eduar
 * Date: 5/31/2016
 * Time: 1:55 AM
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientService
{
    /**
     * @var ClientRepository
     */
    protected $repository;
    /**
     * @var ClientValidator
     */
    private $validator;

    public function __construct(ClientRepository $repository, ClientValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data)
    {
        try
        {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        }catch(ValidatorException $e)
        {
            return ['error' => true, 'message' => $e->getMessageBag()];
        }

    }

    public function destroy($id)
    {
        try
        {
            return $this->repository->delete($id);
        }
        catch(ModelNotFoundException $e)
        {
            return ['error'=>'Client not found.'];
        }
    }
    public function update(array $data, $id)
    {
        try
        {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        }catch(ValidationException $e)
        {
            return ['error' => true, 'message' => $e->getMessageBag()];
        }
    }
}