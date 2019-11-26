<?php

namespace App\Http\Requests\Api\Project;

use App\Models\Project;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ShowProjectRequest
 * @package App\Http\Requests\Api\Project
 *
 * @property Project project
 */
class ShowProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('read', $this->project);
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
