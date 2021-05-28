<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Issue
 * @package App\Models
 *
 * Properties
 * @property int id
 * @property string name
 * @property int project_id
 * @property int issue_type_id
 *
 * Relations
 * @property Project project
 * @property IssueType issue_type
 *
 * Scopes
 * @method static visibleForUser(int $userId)
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

    public function scopeVisibleForUser(Builder $query, int $userId)
    {
        return $query->whereAssignee($userId) // was assigned the issue
            ->orWhere('creator', '=', $userId)// or has created the issue
            ->orWhereHas('project.users', function (Builder $query) use ($userId) { // or is member of the issues project
                return $query->whereUserId($userId);
            })
            ->orWhereHas('project.owner', function(Builder $query) use($userId) { // or is owner of the issues project
                return$query->whereId($userId);
            });
    }

}
