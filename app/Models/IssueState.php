<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IssueState
 * @package App\Models
 *
 * @property int id
 * @property string title
 * @property string icon
 *
 * @property Project project
 */
class IssueState extends Model
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function blobs()
    {
        return $this->belongsToMany();
    }
}
