<?php

namespace App\Http\Requests\Api\Issue;

use App\Models\Issue;
use App\Models\IssueState;
use App\Models\Project;
use App\Models\User;
use App\Rules\Issue\HasReferenceToProject;
use App\Rules\IssueHasReferenceToProject;
use App\Rules\ModelPropertyEquals;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreIssueRequest
 * @package App\Http\Requests\Api\Issue
 *
 * @property Project project
 * @property string name
 * @property int issue_state_id
 */
class StoreIssueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create issue', $this->project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'issue_state_id' => [
                'bail',
                'required',
                'int',
                'exists:issue_states,id',
                new ModelPropertyEquals(IssueState::class, 'project_id', $this->project->id),
            ]
        ];
    }
}
