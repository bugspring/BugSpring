<?php


namespace App\Repositories;


use App\Models\Project;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;

class ProjectRepository
{
    /**
     * @param int $userId
     * @param array $with
     * @return Collection
     */
    public function getProjectsOfUser(int $userId, array $with = []):Collection
    {
        return Project::whereOwnerId($userId)->with($with)->get();
    }

    /**
     * @param int $userId
     * @param array $with
     * @return Collection
     */
    public function getLinkedProjects(int $userId, array $with = []):Collection
    {
        return User::find($userId)->projects;
    }

    /**
     * @param array $data
     * @return Project
     */
    public function createProject(array  $data)
    {
        return Project::create($data);
    }

    /**
     * @param int $id
     * @param array $with
     * @return Project
     */
    public function getProjectById(int $id, array $with=[])
    {
        return Project::whereId($id)->with($with)->firstOrFail();
    }

    /**
     * @param Project $project
     * @param array $data
     * @return Project
     */
    public function updateProject(Project $project, array $data)
    {
        $project->update($data);
        return $this->getProjectById($project->id);
    }

    /**
     * @param Project $project
     * @return Project
     * @throws Exception
     */
    public function deleteProject(Project $project)
    {
        $project->delete();
        return $project;
    }


}
