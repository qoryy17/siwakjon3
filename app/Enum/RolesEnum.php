<?php

namespace App\Enum;

enum RolesEnum: string
{
    case SUPERADMIN = 'Superadmin';
    case ADMIN = 'Administrator';
    case USER = 'User';
}
