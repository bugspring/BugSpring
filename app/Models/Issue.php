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
 */
class Issue extends Model
{
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
