<?php

namespace App\Helpers;

class ClearSessionHelper
{
    public static function clearSession($request)
    {
        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerate();
        $request->session()->regenerateToken();
    }
}
