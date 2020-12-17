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
 * @property int issue_type_id
 *
 * @property Project project
 * @property IssueType issue_type
 */
class Issue extends Model
{
    protected $fillable = [
        'name',
        'project_id',
        'issue_type_id',
        'creator'
    ];
    protected $with     = ['issue_type'];
    protected $hidden   = ['issue_type_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function issue_type()
    {
        return $this->belongsTo(IssueType::class);
    }

}
