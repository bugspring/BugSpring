<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\DeleteUserRequest;
use App\Http\Requests\Api\User\IndexUserRequest;
use App\Http\Requests\Api\User\ShowUserRequest;
use App\Http\Requests\Api\User\StoreUserRequest;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;

class UserController extends Controller
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Models\User[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index(IndexUserRequest $request)
    {
        return $this->userRepository->getUsers();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return ApiException
     */
    public function store(StoreUserRequest $request)
    {
        return new ApiException("user.store is not allowed!", 405);
    }

    /**
     * Display the specified resource.
     *
     * @param ShowUserRequest $request
     * @param int $id
     * @param Encrypter $encrypter
     * @return array
     */
    public function show(ShowUserRequest $request, $id, Encrypter $encrypter)
    {
        if ($id == 'session') {
            $session = [
                'user' => $this->userRepository->getUserById($request->user()->id)
            ];

            if($request->hasCookie(Passport::cookie()))
            { // logged in
                $cookie = decrypt($request->cookie(Passport::cookie()), false);
                $payload = JWT::decode(explode('|', $cookie)[1], $encrypter->getKey(), ['HS256']);

                $session['expiry'] = $payload->expiry;
            }


            return $session;
        } else {
            $user = $this->userRepository->getUserById($id);
            return $this->userRepository->getUserById($user->id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $updateData = [];
        if ($request->has('name')) {
            $updateData['name'] = $request->name;
        }
        if ($request->has('email')) {
            $updateData['email'] = $request->email;
        }
        $user = $this->userRepository->updateUser($user, $updateData);
        return response($user, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteUserRequest $request, User $user)
    {
        $user = $this->userRepository->deleteUser($user);
        return response($user, 201);
    }
}
