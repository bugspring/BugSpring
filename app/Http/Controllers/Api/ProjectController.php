<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\DestroyProjectRequest;
use App\Http\Requests\Api\Project\IndexProjectsRequest;
use App\Http\Requests\Api\Project\ShowProjectRequest;
use App\Http\Requests\Api\Project\StoreProjectRequest;
use App\Http\Requests\Api\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use Exception;
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
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return Project
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $updateData = [];

        if($request->has('owner_id')) {
            $updateData['owner_id'] = $request->owner_id;
        }
        if($request->has('name')) {
            $updateData['name'] = $request->name;
        }
        if($request->has('description')) {
            $updateData['description'] = $request->description;
        }

        return $this->projectRepository->updateProject($project, $updateData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyProjectRequest $request
     * @param Project $project
     * @return Project
     * @throws Exception
     */
    public function destroy(DestroyProjectRequest $request, Project $project)
    {
        return $this->projectRepository->deleteProject($project);
    }
}
