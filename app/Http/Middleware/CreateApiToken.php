<?php

namespace App\Http\Middleware;

use App\Util\ApiTokenCookieFactory;
use Closure;
use Laravel\Passport\Http\Middleware\CreateFreshApiToken;

class CreateApiToken extends CreateFreshApiToken
{


    public function __construct(ApiTokenCookieFactory $cookieFactory)
    {
        parent::__construct($cookieFactory);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $this->guard = $guard;

        $response = $next($request);

        if ($this->shouldReceiveFreshToken($request, $response)) {
            $response->withCookie($this->cookieFactory->make(
                $request->user($this->guard)->getAuthIdentifier(), $request->session()->token()
            ));
        }

        return $response;
    }
}
