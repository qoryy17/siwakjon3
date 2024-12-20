<?php

namespace App\Helpers;

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
            return 'Unknown';
        }

        $jabatan = JabatanModel::find($pegawai->jabatan_id);
        if (!$jabatan) {
            return 'Unknown';
        }
        return $jabatan->jabatan;
    }
}
