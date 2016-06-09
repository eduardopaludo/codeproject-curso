<?php
namespace CodeProject\Http\Controllers;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use CodeProject\Validators\ProjectValidator;
use Illuminate\Http\Request;
use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;
class ProjectController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $repository;
    /**
     * @var ProjectService
     */
    private $service;
    /**
     * @param ProjectRepository $repository
     * @param ProjectService $service
     */
    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->service->all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->service->find($id);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->service->destroy($id);
    }

    public function members($id)
    {

        return $this->service->members($id);
    }
    /**
     * Add a project member
     * @param Request $request form request
     * @param integer  $id      project id
     * @return Response
     */
    public function addMember(Request $request, $id)
    {

        return $this->service->addMember($id, $request->get('user_id'));
    }
    /**
     * Remove a project member
     * @param  Request $request form request
     * @param  integer  $id      project id
     * @param  integer  $userId  user id
     * @return Response
     */
    public function removeMember(Request $request, $id, $userId)
    {

        return $this->service->removeMember($id, $userId);
    }
    /**
     * Check if the user is member of a project
     * @param  Request $request form request
     * @param  integer  $id      project id
     * @param  integer  $userId  user id
     * @return boolean
     */
    public function isMember(Request $request, $id, $userId)
    {
        return $this->service->isMember($id, $userId);
    }
}