<?php


namespace App\Util;


use Carbon\Carbon;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Cookie;

class ApiTokenCookieFactory extends \Laravel\Passport\ApiTokenCookieFactory
{
    /**
     * Create a new API token cookie.
     *
     * @param  mixed  $userId
     * @param  string  $csrfToken
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function make($userId, $csrfToken)
    {
        $config = $this->config->get('session');

        $expiration = Carbon::now()->addMinutes($config['lifetime']);

        $cookieExpiration = $expiration;
        if(config('session.expire_on_close', false))
        {
            $cookieExpiration = 0;
        }

        return new Cookie(
            Passport::cookie(),
            $this->createToken($userId, $csrfToken, $expiration),
            $cookieExpiration,
            $config['path'],
            $config['domain'],
            $config['secure'],
            true,
            false,
            $config['same_site'] ?? null
        );
    }
}
