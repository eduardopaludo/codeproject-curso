<?php
/**
 * Created by PhpStorm.
 * User: eduar
 * Date: 5/31/2016
 * Time: 1:55 AM
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectRepository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use CodeProject\Validators\ProjectValidator;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Prettus\Validator\Exceptions\ValidatorException;

class ProjectService
{
    /**
     * @var ProjectRepository
     */
    protected $repository;
    /**
     * @var ProjectValidator
     */
    private $validator;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Storage
     */
    private $storage;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator, Filesystem $filesystem, Storage $storage)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
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

    public function createFile(array $data)
    {
        $project = $this->repository->skipPresenter()->find($data['project_id']);
        $projectFile = $project->files()->create($data);

        $this->storage->put($projectFile->name.".".$data['extension'], $this->filesystem->get($data['file']));
    }

    public function deleteFile($id)
    {
        $file = $this->repository->skipPresenter()->find($id);
        $this->storage->delete($id.'.'.$file->extension);

        return $this->repository->delete($id);
    }

    public function members($id)
    {
        try
        {
            $members = $this->repository->skipPresenter()->find($id)->members;
            if(count($members))
                return $members;
            return [
                'error' => false,
                'message' => 'Não existem membros neste projeto'
            ];
        }
        catch (\Exception $e)
        {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }
    /**
     * Add a member to a project
     *
     * @param  integer $id   project id
     * @param  integer $userId   user id
     * @return json
     */
    public function addMember($id, $userId)
    {
        try
        {
            $this->repository->find($id)->members()->attach($userId);
            return ['success' => true];
        }
        catch (\Exception $e)
        {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }
    /**
     * Remove a member to a project
     *
     * @param  integer $id   project id
     * @param  integer $userId   user id
     * @return json
     */
    public function removeMember($id, $userId)
    {
        try
        {
            $this->repository->find($id)->members()->detach($userId);
            return ['success' => true];
        }
        catch (\Exception $e)
        {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }
    /**
     * Check if a user is member of a project
     *
     * @param  integer $id   project id
     * @param  integer $userId   user id
     * @return json
     */
    public function isMember($id, $userId)
    {
        try
        {
            return $this->repository->find($id)->members()->find($userId) ? ['success' => true, 'isMember' => true] : ['success' => false, 'isMember' => false];
        }
        catch (\Exception $e)
        {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }


}