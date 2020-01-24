<?php


namespace App\Repositories;


use App\Models\IssueState;

class IssueStateRepository
{

    public function syncWithProject(int $projectId, array $issues=[])
    {
        $issueCollection = collect($issues);

        // delete all IssueStates, that are not listed in $issues
        IssueState::whereProjectId($projectId) // all issues of the project
            ->whereNotIn('id', $issueCollection->pluck('id')) // that do not exist in the issues array
            ->delete();

        // create all IssueStates, that don't have an id property in $issues
        $newItems = $issueCollection->reject(function($value, $key) {
            // remove all elements, that have an id property
            return array_key_exists('id', $value);
        });

        foreach ($newItems as $newItem)
        {
            IssueState::create(array_merge($newItem, ['project_id' => $projectId]));
        }

        // update all IssueStates, that have an id property in $issues
        $updatableItems = $issueCollection->reject(function($value, $key) {
            // remove all elements, that don't have an id property
            return !array_key_exists('id', $value);
        });

        foreach ($updatableItems as $updatableItem)
        {
            IssueState::whereId($updatableItem['id'])
                ->update($updatableItem);
        }


        return $this->getIssueStatesOfProject($projectId);
    }

    public function getIssueStateById(int $id, array $with=[])
    {
        return IssueState::whereId($id)->with($with)->firstOrFail();
    }

    public function getIssueStatesOfProject(int $projectId, array $with=[])
    {
        return IssueState::whereProjectId($projectId)->with($with)->get();
    }

}
