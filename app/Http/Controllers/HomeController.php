<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\ViewUser;
use App\Helpers\RouteLink;
use App\Helpers\TimeSession;
use Illuminate\Http\Request;
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
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    public function berandaSuperadmin()
    {
        if (Auth::user()->roles != "Superadmin") {
            $route = RouteLink::homeString(Auth::user()->roles);
            return redirect()->route($route)->with('error', 'Akses kamu dilarang pada halaman ini !');
        }
        $breadcumb = [
            ['title' => 'Home', 'link' => route('home.superadmin'), 'page' => ''],
            ['title' => 'Dashboard', 'link' => route('home.superadmin'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => env('APP_NAME') . ' | ' . 'Dashboard',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb,
            'welcome' => 'Selamat ' . TimeSession::istime() . ', ' . Auth::user()->name,
            'countPengguna' => ViewUser::countPengguna(),
            'countRapatBulan' => ViewUser::countRapatBulan(),
            'countRapatWasbid' => ViewUser::countRapatWasbid(),
            'countMonev' => ViewUser::countMonev(),
            'countRapat' => ViewUser::countRapat(),
            'agendaRapat' => ViewUser::agendaRapat(),
            'logs' => LogsModel::with('user')->orderBy('created_at', 'desc')->first(),
        ];

        return view('home.home-superadmin', $data);
    }

    public function berandaAdmin()
    {
        if (Auth::user()->roles != "Administrator") {
            $route = RouteLink::homeString(Auth::user()->roles);
            return redirect()->route($route)->with('error', 'Akses kamu dilarang pada halaman ini !');
        }

        $breadcumb = [
            ['title' => 'Home', 'link' => route('home.administrator'), 'page' => ''],
            ['title' => 'Dashboard', 'link' => route('home.administrator'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => env('APP_NAME') . ' | ' . 'Dashboard',
            'routeHome' => route('home.administrator'),
            'breadcumbs' => $breadcumb,
            'welcome' => 'Selamat ' . TimeSession::istime() . ', ' . Auth::user()->name
        ];

        return view('home.home-admin', $data);
    }

    public function berandaUser()
    {
        if (Auth::user()->roles != "User") {
            $route = RouteLink::homeString(Auth::user()->roles);
            return redirect()->route($route)->with('error', 'Akses kamu dilarang pada halaman ini !');
        }

        $breadcumb = [
            ['title' => 'Home', 'link' => route('home.user'), 'page' => ''],
            ['title' => 'Dashboard', 'link' => route('home.user'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => env('APP_NAME') . ' | ' . 'Dashboard',
            'routeHome' => route('home.user'),
            'breadcumbs' => $breadcumb,
            'welcome' => 'Selamat ' . TimeSession::istime() . ', ' . Auth::user()->name,
            'countRapatBulan' => ViewUser::countRapatBulan(),
            'countRapatWasbid' => ViewUser::countRapatWasbid(),
            'countMonev' => ViewUser::countMonev(),
            'agendaRapat' => ViewUser::agendaRapat(),
            'informasi' => ViewUser::informasiPengembang(),
            'rapatUser' => ViewUser::rapatUser(),
        ];

        return view('home.home-user', $data);
    }

    public function version()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Dashboard', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Version', 'link' => route('home.version'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => env('APP_NAME') . ' | Version',
            'routeHome' => route('home.user'),
            'breadcumbs' => $breadcumb,
            'version' => VersionModel::orderBy('created_at', 'desc')
        ];

        return view('aplikasi.version', $data);
    }

    public function logs()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Dashboard', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Logs', 'link' => route('home.logs'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => env('APP_NAME') . ' | Logs',
            'routeHome' => route('home.user'),
            'breadcumbs' => $breadcumb,
            'logs' => LogsModel::with('user')->where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
        ];

        return view('aplikasi.data-logs', $data);
    }

    public function pintasanRapat()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->whereHas('klasifikasiRapat', function ($query) {
            $query->where('rapat', '!=', 'Pengawasan');
        })->where('dibuat', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat Dinas', 'link' => route('rapat.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Rapat | Rapat Saya',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb,
            'klasifikasiRapat' => KlasifikasiRapatModel::where('aktif', '=', 'Y')->where('rapat', '!=', 'Pengawasan')->orderBy('created_at', 'desc')->get(),
            'klasifikasiJabatan' => KlasifikasiJabatanModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'rapat' => $rapat
        ];

        return view('rapat.data-rapat', $data);
    }

    public function pintasanPengawasan()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->whereHas('klasifikasiRapat', function ($query) {
            $query->where('rapat', 'Pengawasan');
        })->orderBy('created_at', 'desc')->get();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat Pengawasan', 'link' => route('pengawasan.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Pengawasan Bidang | Rapat Saya',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb,
            'rapat' => $rapat
        ];

        return view('pengawasan.data-rapat-pengawasan', $data);
    }

    public function notifikasi()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Notifikasi', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Pesan Masuk', 'link' => route('pengawasan.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Notifikasi | Pesan Masuk',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb
        ];

        return view('aplikasi.notifikasi', $data);
    }

    public function profil()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Profil', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"'],
        ];

        $pengguna = User::findOrFail(Auth::user()->id);
        if ($pengguna && $pengguna->pegawai_id != null) {
            $pegawai = PegawaiModel::with('user')->with('jabatan')->findOrFail($pengguna->pegawai_id);
        } else {
            $pegawai = null;
        }

        $data = [
            'title' => 'Profil Saya',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'pengguna' => $pengguna,
            'pegawai' => $pegawai
        ];

        return view('pengguna.profil', $data);
    }

    public function gantiPassword(Request $request): RedirectResponse
    {
        // Run additional validated
        $request->validate([
            'password' => [
                'required',
                'min:8',
                'string',
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@$!%*?&]/', // must contain a special character

            ],
        ], [
            'password.required' => 'Password harus harus di isi !',
            'password.min' => 'Password harus mengandung 8 karakter !',
            'password.string' => 'Password harus harus berupa karakter valid !',
            'password.regex' => 'Password harus mengandung huruf kapital, angka dan karakter !',
        ]);

        $formData = [
            'password' => Hash::make(htmlspecialchars($request->input('password'))),
        ];

        $searchAkun = User::findOrFail(Auth::user()->id);

        $save = $searchAkun->update($formData);

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
            if ($search && $search->foto != null) {
                if (Storage::disk('public')->exists($search->foto)) {
                    Storage::disk('public')->delete($search->foto);
                }
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
        LogsModel::create(
            [
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'activity' => Auth::user()->name . ' Memperbarui profil pengguna, timestamp ' . now()
            ]
        );

        return redirect()->route('home.profil')->with('success', 'Profil berhasil di perbarui !');
    }
}
