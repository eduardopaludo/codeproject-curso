<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Services\ProjectFileService;

/**
 * Este controle será temporário, apenas para atender os requisitos do  projeto fase-4. 
 * Na video aula está de uma forma, na avaliação pediram desta forma =P
 * 
 * vamos ver quais rotas irão realmente ser usadas no front, e implemetaremos o metodos 
 * definitivos no ProjectController
 */

class FileController extends Controller
{
    /**
     * @var ProjectRepository
     */
    protected $service;

    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct(ProjectFileService $service)
    {
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

        if (! $request->hasFile('file')) {
            return response()->json([
                'error'=> true, 
                'message' => 'the file field is required'
                ], 422);
        }

        if (! $request->file('file')->isValid())
        {
            return response()->json([
                'error'=> true, 
                'message' => 'Sorry, it was not possible to complete the upload file'
                ], 422);
        }


        $data = [
            'project_id' => $request->input('project_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'file' => $request->file('file'),
            'extension' => $request->file('file')->getClientOriginalExtension(),
        ];

        return $this->service->upload($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($fileId)
    {
         return $this->service->find($fileId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $fileId)
    {
        $file = NULL;
        $extension = NULL;

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
        }

        $data = [
            'project_id' => $request->input('project_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'file' => $file,
            'extension' => $extension,
        ];

        return $this->service->update($data, $fileId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($fileId)
    {
       return ['success' => $this->service->delete($fileId)];
    }
}
