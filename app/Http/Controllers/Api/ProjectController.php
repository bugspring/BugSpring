<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\DestroyProjectRequest;
use App\Http\Requests\Api\Project\IndexProjectsRequest;
use App\Http\Requests\Api\Project\ShowProjectRequest;
use App\Http\Requests\Api\Project\StoreProjectRequest;
use App\Http\Requests\Api\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use App\Repositories\ProjectRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Log;

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
        /** @var User $user */
        $user = $request->user();

        // get own projects
        $projects = $this->projectRepository->getProjectsOfUser($user->id);

        // add linked projects
        $projects = $projects->merge($this->projectRepository->getLinkedProjects($user->id));

        // remove all projects on which the user doesn't has read permission
        $projects = $projects->filter(function(Project $project) use ($user) {
            return Bouncer::can('read', $project);
        });


        return $projects;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     * @return JsonResponse
     */
    public function store(StoreProjectRequest $request)
    {
        $user = $request->user();
        $project = $this->projectRepository->createProject([
            'owner_id' => $user->id,
            'name' => $request->name,
            'description' => $request->description
        ]);

        if($request->has('issue_states'))
        {
            foreach ($request->issue_states as $issue_state)
            {
                $this->projectRepository->createIssueStateForProject($project, $issue_state);
            }
        }

        return response()->json($this->projectRepository->getProjectById($project->id), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  ShowProjectRequest $request
     * @return Project
     */
    public function show(ShowProjectRequest $request, Project $project)
    {
        return $this->projectRepository->getProjectById($project->id);
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

        if($request->has('issue_states')) {

            $project->issue_states()->sync($request->issue_states);

            foreach ($request->issue_states as $issue_state) {
                if(!array_key_exists('id')) {
                    $project->issue_states()->create($issue_state);
                }
            }
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
