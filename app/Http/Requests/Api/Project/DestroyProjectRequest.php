<?php

namespace App\Http\Requests\Api\Project;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DestroyProjectRequest
 * @package App\Http\Requests\Api\Project
 *
 * @property Project project
 */
class DestroyProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('delete', $this->project);
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
