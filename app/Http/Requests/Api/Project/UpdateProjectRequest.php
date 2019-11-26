<?php

namespace App\Http\Requests\Api\Project;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int owner_id
 * @property string name
 * @property string description
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
            'description' => 'sometimes|string'
        ];
    }
}
