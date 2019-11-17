<?php


namespace App\Repositories;


class UserRepository
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function userHasProject(int $userId, int $projectId)
    {
        $project = $this->projectRepository->getProjectById($projectId);
        if($project->owner_id == $userId)
            return true;
        if($project->users->contains('id', $userId))
            return true;
        return false;
    }
}
