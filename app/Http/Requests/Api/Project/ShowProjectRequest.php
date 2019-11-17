<?php

namespace App\Http\Requests\Api\Project;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Http\FormRequest;

class ShowProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var UserRepository $userRepo */
        $userRepo = app(UserRepository::class);

        /** @var User $user */
        $user = $this->user();

        return $userRepo->userHasProject($user->id, $this->project_id);
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
