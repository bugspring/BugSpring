<?php

namespace App\Http\Requests\Api\Issue;

use Illuminate\Foundation\Http\FormRequest;

class IndexIssueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project' => 'optional|numeric|exists:projects,id'
        ];
    }
}
