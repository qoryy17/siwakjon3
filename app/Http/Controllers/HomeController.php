<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\ViewUser;
use App\Helpers\RouteLink;
use App\Helpers\TimeSession;
use App\Models\Pengaturan\LogsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Http\RedirectResponse;
use App\Models\Pengaturan\VersionModel;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Profil\ProfilRequest;
use App\Models\Manajemen\ManajemenRapatModel;
use App\Models\Manajemen\KlasifikasiRapatModel;
use App\Models\Manajemen\KlasifikasiJabatanModel;
use App\Http\Requests\Profil\ChangePasswordRequest;

class HomeController extends Controller
{
    protected $route, $routeHome;
    public function __construct()
    {
        $this->route = RouteLink::homeString(Auth::user()->roles);
        $this->routeHome = RouteLink::homePage(Auth::user()->roles);
    }

    protected function breadCumbs()
    {
        $breadcumb = [
            ['title' => 'Home', 'link' => $this->routeHome, 'page' => ''],
            ['title' => 'Dashboard', 'link' => $this->routeHome, 'page' => 'aria-current="page"']
        ];

        return $breadcumb;
    }
    public function berandaSuperadmin()
    {
        if (Auth::user()->roles !== \App\Enum\RolesEnum::SUPERADMIN->value) {
            return redirect()->route($this->route)->with('error', 'Akses kamu dilarang pada halaman ini !');
        }

        $data = [
            'title' => env('APP_NAME') . ' | ' . 'Dashboard',
            'routeHome' => $this->routeHome,
            'breadcumbs' => $this->breadcumbs(),
            'welcome' => 'Selamat ' . TimeSession::istime() . ', ' . Auth::user()->name,
            'countPengguna' => ViewUser::countPengguna(),
            'countRapatBulan' => ViewUser::countRapatBulan(),
            'countRapatWasbid' => ViewUser::countRapatWasbid(),
            'countMonev' => ViewUser::countMonev(),
            'countRapat' => ViewUser::countRapat(),
            'agendaRapat' => ViewUser::agendaRapat(),
            'logs' => LogsModel::with('user')->orderBy('created_at', 'desc')->first(),
            'statistikRapat' => $this->loadPieChart(),
        ];

        return view('home.home-superadmin', $data);
    }

    public function berandaAdmin()
    {
        if (Auth::user()->roles !== \App\Enum\RolesEnum::ADMIN->value) {
            return redirect()->route($this->route)->with('error', 'Akses kamu dilarang pada halaman ini !');
        }

        $data = [
            'title' => env('APP_NAME') . ' | ' . 'Dashboard',
            'routeHome' => $this->routeHome,
            'breadcumbs' => $this->breadcumbs(),
            'welcome' => 'Selamat ' . TimeSession::istime() . ', ' . Auth::user()->name,
            'countRapatBulan' => ViewUser::countRapatBulan(),
            'countRapatWasbid' => ViewUser::countRapatWasbid(),
            'countMonev' => ViewUser::countMonev(),
            'agendaRapat' => ViewUser::agendaRapat(),
            'informasi' => ViewUser::informasiPengembang(),
            'pengawasTercepat' => ViewUser::pengawasTercepat(),
            'monev' => ViewUser::monev(),
            'statistikRapat' => $this->loadPieChart(),
            'edocWasbidKosong' => ViewUser::edocWasbidKosong(),
        ];

        return view('home.home-admin', $data);
    }

    public function berandaUser()
    {
        if (Auth::user()->roles !== \App\Enum\RolesEnum::USER->value) {
            return redirect()->route($this->route)->with('error', 'Akses kamu dilarang pada halaman ini !');
        }

        $data = [
            'title' => env('APP_NAME') . ' | ' . 'Dashboard',
            'routeHome' => $this->routeHome,
            'breadcumbs' => $this->breadcumbs(),
            'welcome' => 'Selamat ' . TimeSession::istime() . ', ' . Auth::user()->name,
            'countRapatBulan' => ViewUser::countRapatBulan(),
            'countRapatWasbid' => ViewUser::countRapatWasbid(),
            'countMonev' => ViewUser::countMonev(),
            'agendaRapat' => ViewUser::agendaRapat(),
            'informasi' => ViewUser::informasiPengembang(),
            'rapatUser' => ViewUser::rapatUser(),
            'carouselWasbid' => ViewUser::kimWasbid(),
            'statistikRapat' => $this->loadPieChart(),
        ];

        return view('home.home-user', $data);
    }

    protected function loadPieChart()
    {
        $bulanan = ViewUser::countRapatByCategory('Bulanan');
        $berjenjang = ViewUser::countRapatByCategory('Berjenjang');
        $lainnya = ViewUser::countRapatByCategory('Lainnya');
        $pengawasan = ViewUser::countRapatByCategory('Pengawasan');
        return [
            'bulanan' => $bulanan,
            'berjenjang' => $berjenjang,
            'lainnya' => $lainnya,
            'pengawasan' => $pengawasan
        ];
    }

    public function version()
    {
        $breadCumb = $this->breadCumbs();
        $breadCumb[] = ['title' => 'Version', 'link' => route('home.version'), 'page' => 'aria-current="page"'];

        $data = [
            'title' => env('APP_NAME') . ' | Version',
            'routeHome' => $this->routeHome,
            'breadcumbs' => $breadCumb,
            'version' => VersionModel::orderBy('created_at', 'desc'),
            'singleVersion' => VersionModel::orderBy('created_at', 'desc')
        ];

        return view('aplikasi.version', $data);
    }

    public function logs()
    {
        $breadcumb = $this->breadCumbs();
        $breadcumb[] = ['title' => 'Logs', 'link' => route('home.logs'), 'page' => 'aria-current="page"'];

        $data = [
            'title' => env('APP_NAME') . ' | Logs',
            'routeHome' => $this->routeHome,
            'breadcumbs' => $breadcumb,
            'logs' => LogsModel::with('user')->where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
        ];

        return view('aplikasi.data-logs', $data);
    }

    public function pintasanRapat()
    {
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')
            ->whereHas('klasifikasiRapat', function ($query) {
                $query->where('rapat', '!=', 'Pengawasan');
            })->where('dibuat', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        $breadcumb = $this->breadCumbs();
        $breadcumb[] = ['title' => 'Rapat Dinas', 'link' => route('rapat.index'), 'page' => 'aria-current="page"'];

        $data = [
            'title' => 'Manajemen Rapat | Rapat Saya',
            'routeHome' => $this->routeHome,
            'breadcumbs' => $breadcumb,
            'klasifikasiRapat' => KlasifikasiRapatModel::where('aktif', '=', 'Y')->where('rapat', '!=', 'Pengawasan')->orderBy('created_at', 'desc')->get(),
            'klasifikasiJabatan' => KlasifikasiJabatanModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'rapat' => $rapat
        ];

        return view('rapat.data-rapat', $data);
    }

    public function pintasanPengawasan()
    {
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')
            ->whereHas('klasifikasiRapat', function ($query) {
                $query->where('rapat', 'Pengawasan');
            })->orderBy('created_at', 'desc')->get();

        $breadcumb = $this->breadCumbs();
        $breadcumb[] = ['title' => 'Rapat Pengawasan', 'link' => route('pengawasan.index'), 'page' => 'aria-current="page"'];

        $data = [
            'title' => 'Pengawasan Bidang | Rapat Saya',
            'routeHome' => $this->routeHome,
            'breadcumbs' => $breadcumb,
            'rapat' => $rapat
        ];

        return view('pengawasan.data-rapat-pengawasan', $data);
    }

    public function profil()
    {
        $breadcumb = $this->breadCumbs();
        $breadcumb[] = ['title' => 'Profil', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"'];

        $pengguna = Auth::user();
        $pegawai = $pengguna->pegawai_id ? PegawaiModel::with(['user', 'jabatan'])->find($pengguna->pegawai_id) : null;

        $data = [
            'title' => 'Profil Saya',
            'routeHome' => $this->routeHome,
            'breadcumbs' => $breadcumb,
            'pengguna' => $pengguna,
            'pegawai' => $pegawai
        ];

        return view('pengguna.profil', $data);
    }

    public function gantiPassword(ChangePasswordRequest $request): RedirectResponse
    {
        // Run additional validated
        $request->validated();

        $formData = [
            'password' => Hash::make(htmlspecialchars($request->input('password'))),
        ];

        $searchAkun = User::findOrFail(Auth::user()->id);

        $save = $searchAkun->update($formData);
        if (!$save) {
            return redirect()->back()->with('error', 'Password gagal diperbarui !');
        }

        // Must logout after password has been changed
        Auth::logout();
        $request->session()->regenerate();
        return redirect()->route('signin')->with('success', 'Password berhasil diubah silahkan login ulang !');
    }

    public function saveProfil(ProfilRequest $request): RedirectResponse
    {
        // Set directory
        $directory = 'images/pegawai/';
        $search = PegawaiModel::findOrFail(Auth::user()->pegawai_id);

        $formData = [
            'nip' => htmlspecialchars($request->input('nip')),
            'nama' => htmlspecialchars($request->input('nama')),
            'keterangan' => nl2br(htmlspecialchars($request->input('keterangan'))),
        ];

        if ($request->file('foto')) {
            // Delete old foto
            if (!empty($search->foto) && Storage::disk('public')->exists($search->foto)) {
                Storage::disk('public')->delete($search->foto);
            }
            // Foto upload process
            $fileFoto = $request->file('foto');
            $fileHashname = $fileFoto->hashName();
            $uploadPath = $directory . $fileHashname;
            $fileUpload = $fileFoto->storeAs($directory, $fileHashname, 'public');

            // If Foto has failed to upload
            if (!$fileUpload) {
                return redirect()->back()->with('error', 'Unggah Foto gagal !')->withInput();
            }

            $formData['foto'] = $uploadPath;
        }

        $save = $search->update($formData);

        if (!$save) {
            return redirect()->route('home.profil')->with('error', 'Profil gagal di perbarui !');
        }
        // Save email user
        $user = User::findOrFail(Auth::user()->id);
        $user->update(['email' => htmlspecialchars($request->input('email'))]);
        // Saving logs activity
        $activity = 'Mengubah profil';
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->route('home.profil')->with('success', 'Profil berhasil di perbarui !');
    }

}
