<?php

namespace App\Http\Middleware;

use Closure;
use App\Enum\RolesEnum;
use App\Enum\JabatanEnum;
use App\Helpers\ViewUser;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RejectNonHakimMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // This middleware accept for Hakim, Wakil Ketua, Ketua, Administrator and Superadmin
        $jabatan = ViewUser::jabatan();

        if (
            $jabatan == JabatanEnum::HAKIM->value ||
            $jabatan == JabatanEnum::KETUA->value ||
            $jabatan == JabatanEnum::WAKIL->value ||
            Auth::user()->roles == RolesEnum::SUPERADMIN->value
            || Auth::user()->roles == RolesEnum::ADMIN->value
        ) {
            return $next($request);
        }
        $route = RouteLink::homeString(Auth::user()->roles);
        return redirect()->route($route)->with('error', 'You are not authorized to access this page');
    }
}
