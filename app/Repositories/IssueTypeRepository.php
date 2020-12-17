<?php


namespace App\Repositories;

use App\Models\IssueType;

class IssueTypeRepository
{

    public function syncWithProject(int $projectId, array $issues = [])
    {
        $issueCollection = collect($issues);

        // delete all IssueTypes, that are not listed in $issues
        IssueType::whereProjectId($projectId) // all issues of the project
        ->whereNotIn('id', $issueCollection->pluck('id')) // that do not exist in the issues array
        ->delete();

        // create all IssueTypes, that don't have an id property in $issues
        $newItems = $issueCollection->reject(function ($value, $key) {
            // remove all elements, that have an id property
            return array_key_exists('id', $value);
        });

        foreach ($newItems as $newItem) {
            IssueType::create(array_merge($newItem, ['project_id' => $projectId]));
        }

        // update all IssueTypes, that have an id property in $issues
        $updatableItems = $issueCollection->reject(function ($value, $key) {
            // remove all elements, that don't have an id property
            return !array_key_exists('id', $value);
        });

        foreach ($updatableItems as $updatableItem) {
            IssueType::whereId($updatableItem['id'])
                ->update($updatableItem);
        }


        return $this->getIssueTypesOfProject($projectId);
    }

    public function getIssueTypeById(int $id, array $with = [])
    {
        return IssueType::whereId($id)->with($with)->firstOrFail();
    }

    public function getIssueTypesOfProject(int $projectId, array $with = [])
    {
        return IssueType::whereProjectId($projectId)->with($with)->get();
    }

}
