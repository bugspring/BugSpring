<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

/**
 * Class Project
 * @package App\Models
 *
 * @property int id
 * @property int owner_id
 * @property string name
 * @property string description
 * @property Date created_at
 * @property Date updated_at
 * @property Date deleted_at
 */
class Project extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'description'
    ];
    protected $with = ['issue_states'];
    protected $hidden = ['pivot'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function issue_states() {
        return $this->hasMany(IssueState::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
