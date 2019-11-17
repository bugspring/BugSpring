<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\IndexProjectsRequest;
use App\Http\Requests\Api\Project\ShowProjectRequest;
use App\Http\Requests\Api\Project\StoreProjectRequest;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexProjectsRequest $request
     * @return \Illuminate\Support\Collection
     */
    public function index(IndexProjectsRequest $request)
    {
        $user = $request->user();
        $projects = $this->projectRepository->getProjectsOfUser($user->id);
        $projects = $projects->merge($this->projectRepository->getLinkedProjects($user->id));

        return $projects;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     * @return Project
     */
    public function store(StoreProjectRequest $request)
    {
        $user = $request->user();
        return $this->projectRepository->createProject([
            'owner_id' => $user->id,
            'name' => $request->name,
            'description' => $request->description
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  ShowProjectRequest $request
     * @return Project
     */
    public function show(ShowProjectRequest $request, $id)
    {
        return $this->projectRepository->getProjectById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
