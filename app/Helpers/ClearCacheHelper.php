<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class ClearCacheHelper
{
    public static function clearCache()
    {
        // Clear cache
        cache()->forget('auth_pegawai_' . Auth::id());
        cache()->forget('pegawai_id_' . Auth::user()->pegawai_id);
        cache()->forget('pengguna_' . Auth::id());
        cache()->forget('user_unit_kerja_' . Auth::id());
        cache()->forget('jabatan_' . Auth::user()->pegawai_id);
        cache()->forget('latest_app_version');
        cache()->forget('kim_wasbid_data');
    }
}
