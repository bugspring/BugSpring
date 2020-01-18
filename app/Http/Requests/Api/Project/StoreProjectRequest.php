<?php

namespace App\Http\Requests\Api\Project;

use App\Models\Project;
use App\Util\MaterialDesignIcons;
use Illuminate\Foundation\Http\FormRequest;
use Bouncer;
/**
 * Class StoreProjectRequest
 * @package App\Http\Requests\Api\Project
 *
 * @property string name
 * @property string description
 * @property array issue_states
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
        return $this->user()->can('create project');
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
            'description' => 'required|string',
            'issue_states' => 'sometimes|array',
            'issue_states.title' => 'required|string',
            'issue_states.icon' => 'required|string|in:'.implode(',', MaterialDesignIcons::NAMES),
        ];
    }
}
