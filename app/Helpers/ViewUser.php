<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Arsip\ArsipMonevModel;
use App\Models\Manajemen\DetailRapatModel;
use App\Models\Manajemen\ManajemenRapatModel;
use App\Models\Pengaturan\NoteDeveloperModel;
use App\Models\Pengguna\JabatanModel;
use App\Models\Pengguna\PegawaiModel;

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

    public static function countPengguna()
    {
        return User::count();
    }

    public static function countMonev()
    {
        return ArsipMonevModel::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
    }

    public static function countRapatBulan()
    {
        return ManajemenRapatModel::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
    }

    public static function countRapatWasbid()
    {
        return ManajemenRapatModel::with('klasifikasiRapat')
            ->whereHas('klasifikasiRapat', function ($query) {
                $query->where('rapat', 'Pengawasan');
            })
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();
    }

    public static function countRapat()
    {
        return DetailRapatModel::whereYear('created_at', date('Y'))->where('notulen', '=', null)->count();
    }

    public static function agendaRapat()
    {
        return ManajemenRapatModel::with('detailRapat')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
    }

    public static function countTotalRapatUser()
    {
        return ManajemenRapatModel::where('dibuat', '=', Auth::user()->id)->count();
    }

    public static function informasiPengembang()
    {
        return NoteDeveloperModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc');
    }

    public static function rapatUser()
    {
        return ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->where('dibuat', '=', Auth::user()->id)->orderBy('created_at', 'desc')->limit(5);
    }
}
