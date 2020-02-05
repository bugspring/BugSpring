<?php

namespace App\Http\Requests\Api\Issue;

use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
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
            'issue_state_id' => 'required|int|exists:issue_states,id'
        ];
    }
}
