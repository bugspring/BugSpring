<?php


namespace App\Repositories;


use App\Models\Issue;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class IssueRepository
{
    public function getIssuesByProjectId($id):Collection
    {
        return Issue::whereProjectId($id)->get();
    }

    public function createIssue(array $data):Issue
    {
        return Issue::create($data);
    }

    public function getIssueById(int $id):Issue
    {
        return Issue::whereId($id)->firstOrFail();
    }

    public function updateIssue(Issue $issue, array $data):Issue
    {
        $issue->update($data);
        return $this->getIssueById($issue->id);
    }

    public function deleteIssue(Issue $issue):Issue
    {
        $issue->delete();
        return $issue;
    }
}
