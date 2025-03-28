<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Arsip\ArsipMonevModel;
use App\Models\Manajemen\DetailRapatModel;
use App\Models\Manajemen\EdocWasbidModel;
use App\Models\Manajemen\ManajemenRapatModel;
use App\Models\Manajemen\PengawasanBidangModel;
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
        return ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->orderBy('created_at', 'desc')->limit(5);
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

    public static function pengawasTercepat()
    {
        $getEdoc = EdocWasbidModel::orderBy('created_at', 'asc')->limit(1)->first();
        if ($getEdoc) {
            // Search rapat pengawasan
            $pengawasan = PengawasanBidangModel::where('status', '=', 'Waiting')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->where('id', '=', $getEdoc->pengawasan_bidang_id);

            return $pengawasan;
        } else {
            return null;
        }
    }

    public static function monev()
    {
        return ArsipMonevModel::orderBy('created_at', 'desc')->limit(3);
    }
}
