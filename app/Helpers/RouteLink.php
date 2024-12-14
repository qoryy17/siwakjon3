<?php

namespace App\Helpers;

use DateTime;
use App\Enum\RolesEnum;
use Illuminate\Support\Facades\Auth;

class RouteLink
{
    public static function homePage($roles): string
    {
        if (RolesEnum::SUPERADMIN->value == $roles) {
            $route = route('home.superadmin');
        } elseif (RolesEnum::ADMIN->value == $roles) {
            $route = route('home.administrator');
        } elseif (RolesEnum::USER->value == $roles) {
            $route = route('home.user');
        } else {
            Auth::logout();
            return redirect()->route('signin')->with('error', 'Routing roles not found !');
        }

        return $route;
    }

    public static function homeString($roles): string
    {
        if (RolesEnum::SUPERADMIN->value == $roles) {
            $route = 'home.superadmin';
        } elseif (RolesEnum::ADMIN->value == $roles) {
            $route = 'home.administrator';
        } elseif (RolesEnum::USER->value == $roles) {
            $route = 'home.user';
        } else {
            Auth::logout();
            return redirect()->route('signin')->with('error', 'Routing roles not found !');
        }

        return $route;
    }

    public static function homeAuth($roles): string
    {
        if (RolesEnum::SUPERADMIN->value == $roles) {
            $route = redirect()->route('home.superadmin');
        } elseif (RolesEnum::ADMIN->value == $roles) {
            $route = redirect()->route('home.administrator');
        } elseif (RolesEnum::USER->value == $roles) {
            $route = redirect()->route('home.user');
        } else {
            Auth::logout();
            return redirect()->route('signin')->with('error', 'Routing roles not found !');
        }

        return $route;
    }

    public static function homeIntended($roles): string
    {
        if (RolesEnum::SUPERADMIN->value == $roles) {
            $route = 'dashboard/superadmin';
        } elseif (RolesEnum::ADMIN->value == $roles) {
            $route = 'dashboard/administrator';
        } elseif (RolesEnum::USER->value == $roles) {
            $route = 'dashboard/user';
        } else {
            Auth::logout();
            return redirect()->route('signin')->with('error', 'Routing roles not found !');
        }

        return $route;
    }
}
