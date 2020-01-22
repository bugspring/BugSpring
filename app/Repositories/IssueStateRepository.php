<?php


namespace App\Repositories;


use App\Models\IssueState;

class IssueStateRepository
{

    public function syncWithProject(int $projectId, array $issues=[])
    {
        $issueCollection = collect($issues);

        IssueState::whereProjectId($projectId) // all issues of the project
            ->whereNotIn('project_id', $issueCollection->pluck('id')) // that do not exist in the issues array
            ->delete();

        $newItems = $issueCollection->reject(function($value, $key) {
            return !array_key_exists('id', $value);
        });

        foreach ($newItems as $newItem)
        {
            IssueState::create($newItems);
        }

        return IssueState::whereProjectId($projectId);

    }
}
