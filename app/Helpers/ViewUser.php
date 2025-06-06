<?php

namespace App\Helpers;

use App\Models\Arsip\AgendaMonevModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Arsip\ArsipMonevModel;
use App\Models\Hakim\HakimPengawasModel;
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
        $userId = Auth::user()->pegawai_id;
        return cache()->memo()->remember("pegawai_id_" . $userId, 60, function () use ($userId) {
            return PegawaiModel::find($userId);
        });
    }

    public static function pengguna($id = null)
    {
        return cache()->memo()->remember("pengguna_" . $id, 60, function () use ($id) {
            $user = User::find($id);
            if (!$user) {
                return null;
            }
            return $user->name;
        });
    }

    public static function unitKerja()
    {
        $userId = Auth::user()->id;
        return cache()->memo()->remember("user_unit_kerja_" . $userId, 60, function () use ($userId) {
            $user = User::with('unitKerja')->find($userId);
            if (!$user) {
                return null;
            }
            return $user;
        });
    }

    public static function jabatan()
    {
        $userId = Auth::user()->pegawai_id;
        return cache()->memo()->remember("jabatan_" . $userId, 60, function () use ($userId) {
            $pegawai = PegawaiModel::with('jabatan')->find($userId);
            if (!$pegawai || !$pegawai->jabatan) {
                return 'Unknown';
            }
            return $pegawai->jabatan->jabatan;
        });
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
            ->where('dibuat', '=', Auth::user()->id)->orderBy('created_at', 'desc')->limit(10);
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
        return AgendaMonevModel::orderBy('created_at', 'desc')->limit(5);
    }

    public static function countRapatByCategory($category)
    {
        return ManajemenRapatModel::with('klasifikasiRapat')->whereHas('klasifikasiRapat', function ($query) use ($category) {
            $query->where('rapat', $category);
        })->whereYear('created_at', date('Y'))->count();
    }

    public static function edocWasbidKosong()
    {
        return PengawasanBidangModel::with('detailRapat')->with('edocWasbid')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->orderBy('created_at', 'desc')->limit(5);
    }

    public static function kimWasbid()
    {
        $kimWasbid = HakimPengawasModel::with('pegawai')->with('unitKerja')->whereHas('pegawai', function ($query) {
            $query->where('aktif', 'Y');
        })->where('aktif', 'Y')->orderBy('ordering', 'asc');

        $countKimWasbid = HakimPengawasModel::with('pegawai')->with('unitKerja')->whereHas('pegawai', function ($query) {
            $query->where('aktif', 'Y');
        })->where('aktif', 'Y')->count();

        return [
            'kimWasbid' => $kimWasbid,
            'countKimWasbid' => $countKimWasbid,
        ];
    }
}
