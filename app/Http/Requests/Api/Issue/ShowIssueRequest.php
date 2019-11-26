<?php

namespace App\Http\Requests\Api\Issue;

use App\Models\Issue;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ShowIssueRequest
 * @package App\Http\Requests\Api\Issue
 *
 * @property Issue issue
 * @property Project project
 */
class ShowIssueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('read', $this->issue);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
