<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Issue\IndexIssueRequest;
use App\Http\Requests\Api\Issue\ShowIssueRequest;
use App\Http\Requests\Api\Issue\StoreIssueRequest;
use App\Http\Requests\Api\Issue\UpdateIssueRequest;
use App\Http\Requests\Api\Project\ShowProjectRequest;
use App\Http\Requests\DestroyIssueRequest;
use App\Models\Issue;
use App\Models\Project;
use App\Repositories\IssueRepository;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * @var IssueRepository
     */
    private $issueRepository;

    public function __construct(IssueRepository $issueRepository)
    {
        $this->issueRepository = $issueRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexIssueRequest $request
     * @param Project $project
     * @param Issue $issue
     * @return Issue[]
     */
    public function index(IndexIssueRequest $request, Project $project)
    {
        $user = $request->user();
        return $this->issueRepository->getIssuesByProjectId($project->id)
            ->filter(function (Issue $issue) use ($user) {
                return $user->can('read', $issue);
            });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreIssueRequest $request
     * @param Project $project
     * @return Issue
     */
    public function store(StoreIssueRequest $request, Project $project)
    {
        return $this->issueRepository->createIssue([
            'name' => $request->name,
            'project_id' => $project->id,
            'issue_state_id' => $request->issue_state_id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param ShowIssueRequest $request
     * @param Issue $issue
     * @return Issue
     */
    public function show(ShowIssueRequest $request, Project $project, Issue $issue)
    {
        if ($project->id != $issue->project_id) {
            throw new ApiException("Issue id not found in project", 404);
        }
        return $this->issueRepository->getIssueById($issue->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateIssueRequest $request
     * @param Project $project
     * @param Issue $issue
     * @return Issue
     */
    public function update(UpdateIssueRequest $request, Project $project, Issue $issue)
    {
        if ($project->id != $issue->project_id) {
            throw new ApiException("Issue not found in project", 404);
        }

        $data = [];

        if ($request->has('name')) {
            $data['name'] = $request->name;
        }
        if ($request->has('issue_state_id')) {
            $data['issue_state_id'] = $request->issue_state_id;
        }

        return $this->issueRepository->updateIssue($issue, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyIssueRequest $request
     * @param Issue $issue
     * @return Issue
     */
    public function destroy(DestroyIssueRequest $request, Project $project, Issue $issue)
    {
        if ($project->id != $issue->project_id) {
            throw new ApiException("Issue id not found in project", 404);
        }

        return $this->issueRepository->deleteIssue($issue);
    }
}
