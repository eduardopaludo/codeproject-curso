<?php
/**
 * Created by PhpStorm.
 * User: eduar
 * Date: 5/31/2016
 * Time: 1:55 AM
 */

namespace CodeProject\Services;


use CodeProject\Entities\Project;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectNoteValidator;
use CodeProject\Validators\ProjectValidator;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectNoteService
{
    /**
     * @var ProjectNoteRepository
     */
    protected $repository;
    /**
     * @var ProjectNoteValidator
     */
    private $validator;

    public function __construct(ProjectNoteRepository $repository, ProjectNoteRepository $validator)
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
            return ['error'=>'Project not found.'];
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