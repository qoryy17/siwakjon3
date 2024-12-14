<?php

namespace App\Helpers;

use DateTime;
use App\Enum\RolesEnum;
use App\Models\Pengguna\JabatanModel;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Support\Facades\Auth;

class ViewUser
{
    public static function pegawai()
    {
        $pegawai = PegawaiModel::find(Auth::user()->pegawai_id);
        if (!$pegawai) {
            return null;
        }
        return $pegawai;
    }

    public static function jabatan()
    {
        $pegawai = PegawaiModel::find(Auth::user()->pegawai_id);
        if (!$pegawai) {
            return 'Developer';
        }

        $jabatan = JabatanModel::find($pegawai->jabatan_id);
        if (!$jabatan) {
            return 'Developer';
        }
        return $jabatan->jabatan;
    }
}
