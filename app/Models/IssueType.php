<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IssueType
 * @package App\Models
 *
 * @property int id
 * @property string title
 * @property string icon
 * @property int project_id
 *
 * @property Project project
 * @property Issue[] issues
 */
class IssueType extends Model
{
    protected $fillable = [
        'id',
        'title',
        'icon',
        'project_id'
    ];


    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function issues() {
        return $this->hasMany(Issue::class);
    }
}
