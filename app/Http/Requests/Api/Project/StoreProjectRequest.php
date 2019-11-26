<?php

namespace App\Http\Requests\Api\Project;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Bouncer;
/**
 * Class StoreProjectRequest
 * @package App\Http\Requests\Api\Project
 *
 * @property string name
 * @property string description
 */
class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return $this->user()->can('create', Project::class);
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
            'description' => 'required|string'
        ];
    }
}
