<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCartToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->cookie('cart_token')) {
            $token = Str::random(40);
            $response = $next($request);
            return $response->withCookie(cookie('cart_token', $token, 60*24*30)); // 30 days
        }
        return $next($request);
    }
}