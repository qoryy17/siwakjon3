<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Handle if user is not login
        if (!Auth::check()) {
            return redirect()->route('signin')->with('error', 'Silahkan login dulu !');
        }

        // Handle if user account has not active
        if (Auth::user()->active == 0) {
            Auth::logout();
            return redirect()->route('signin')->with('error', 'Akun ada sedang terblokir !');
        }
        return $next($request);
    }
}
