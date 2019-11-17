<?php


namespace App\Repositories;


use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;

class ProjectRepository
{
    public function getProjectsOfUser(int $userId, array $with = []):Collection
    {
        return Project::whereOwnerId($userId)->with($with)->get();
    }

    public function getLinkedProjects(int $userId, array $with = []):Collection
    {
        return User::find($userId)->projects;
    }

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

}
