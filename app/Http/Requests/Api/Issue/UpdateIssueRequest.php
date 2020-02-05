<?php

namespace App\Http\Requests\Api\Issue;

use App\Models\Issue;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateIssueRequest
 * @package App\Http\Requests\Api\Issue
 *
 * @property Issue issue
 * @property Project project
 * @property string name
 * @property int issue_state_id
 */
class UpdateIssueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->issue);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|string',
            'issue_state_id' => 'sometimes|int|exists:issue_states,id'
        ];
    }
}
