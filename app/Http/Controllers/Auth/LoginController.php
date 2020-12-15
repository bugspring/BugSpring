<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        login as traitLogin;
        logout as traitLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/web';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function showLoginForm(Request $request)
    {
        $data = [];

        if ($request->has(config('view.login.redirect_param'))) {
            $data['redirectUrl'] = $request[config('view.login.redirect_param')];
        }

        if ($request->has(config('view.login.error_param'))) {
            switch ($request[config('view.login.error_param')]) {
                case 401:
                    $data['error'] = trans('errors.unauthorized');
                    break;
                default:
                    $data['error'] = trans('errors.unknown', ['error' => $request->error]);
            }
        }

        return view('auth.login', $data);
    }

    public function login(Request $request)
    {
        if ($request->has('redirectUrl')) {
            $this->redirectTo .= '#' . $request->redirectUrl;
        }
        return $this->traitLogin($request);
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return $this->loggedOut($request) ?: redirect('/login');
    }


}
