<?php


namespace App\Repositories;


use App\Models\Issue;

class IssueRepository
{
    public function getIssuesByProjectId($id)
    {
        return Issue::whereProjectId($id)->get();
    }

    public function createIssue(array $data)
    {
        return Issue::create($data);
    }

    public function getIssueById(int $id)
    {
        return Issue::whereId($id)->firstOrFail();
    }
}
