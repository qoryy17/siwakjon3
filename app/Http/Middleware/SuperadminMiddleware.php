<?php

namespace App\Http\Middleware;

use Closure;
use App\Enum\RolesEnum;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperadminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->roles != RolesEnum::SUPERADMIN->value) {
            $route = RouteLink::homeString(Auth::user()->roles);
            return redirect()->route($route)->with('error', 'You are not authorized to access this page');
        }
        return $next($request);
    }
}
