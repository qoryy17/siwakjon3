<?php

namespace App\Http\Middleware;

use App\Helpers\RouteLink;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NonAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Handle checking Auth user and redirect with role
        if (Auth::check()) {
            $route = RouteLink::homeString(Auth::user()->roles);
            return redirect()->route($route);
        }
        return $next($request);
    }
}
