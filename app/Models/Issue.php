<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Issue
 * @package App\Models
 *
 * @property int id
 * @property string name
 * @property int project_id
 * @property int issue_state_id
 *
 * @property Project project
 * @property IssueState issue_state
 */
class Issue extends Model
{
    protected $fillable = [
        'name',
        'project_id',
        'issue_state_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function issue_state()
    {
        return $this->belongsTo(IssueState::class);
    }

}
