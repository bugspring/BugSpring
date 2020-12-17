<?php

namespace App\Models;

use App\Repositories\ProjectRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

/**
 * Class Project
 * @package App\Models
 *
 * // simple properties
 * @property int id
 * @property int owner_id
 * @property string name
 * @property string description
 * @property Date created_at
 * @property Date updated_at
 * @property Date deleted_at
 *
 * // relations
 * @property User owner
 * @property Collection<User> Users
 * @property Collection<Issue> Issues
 *
 * // appended
 * @property bool is_favorite
 */
class Project extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'description',
        'is_favorite'
    ];
    protected $with     = ['issue_types'];
    protected $hidden   = ['pivot'];

    protected $appends = ['is_favorite'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function issue_types()
    {
        return $this->hasMany(IssueType::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function getIsFavoriteAttribute()
    {
        if (Auth::check()) {
            /** @var ProjectRepository $projectRepo */
            $projectRepo = app(ProjectRepository::class);

            return $projectRepo->isFavoredByUser($this->id, Auth::user()->id);
        }
        return false;
    }

    public function setIsFavoriteAttribute($isFavorite)
    {
        if ($isFavorite == $this->is_favorite) {
            return;
        }
        if (Auth::check()) {
            /** @var ProjectRepository $projectRepo */
            $projectRepo = app(ProjectRepository::class);

            if ($isFavorite) {
                $projectRepo->addToFavorites($this->id, Auth::user()->id);
            } else {
                $projectRepo->removeFromFavorites($this->id, Auth::user()->id);
            }
        }
    }
}
