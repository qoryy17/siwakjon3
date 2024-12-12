<?php

namespace App\Helpers;

use DateTime;
use App\Enum\RolesEnum;

class RouteLink
{
    public static function homePage()
    {
        if (RolesEnum::SUPERADMIN->value == 'Superadmin') {
            $route = route('home.superadmin');
        } elseif (RolesEnum::SUPERADMIN->value == 'Administrator') {
            $route = route('home.administrator');
        } else {
            $route = route('home.user');
        }
        return $route;
    }
}
