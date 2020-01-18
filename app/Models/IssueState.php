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

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
