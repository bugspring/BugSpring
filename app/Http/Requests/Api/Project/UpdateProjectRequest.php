<?php

namespace App\Http\Requests\Api\Project;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int owner_id
 * @property string name
 * @property string description
 * @property array issue_types
 *
 * @property bool is_favorite
 * @property Project project
 */
class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'owner_id' => 'sometimes|int|exists:users,id',
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'issue_types' => 'sometimes|array',
            'issue_types.*.id' => 'sometimes|int|exists:issue_types,id',
            'issue_types.*.title' => 'sometimes|string|distinct',
            'issue_types.*.icon'  => 'sometimes|string',
            'is_favorite' => 'sometimes|boolean'
        ];
    }
}
