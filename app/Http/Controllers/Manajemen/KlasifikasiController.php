<?php

namespace App\Http\Controllers\Manajemen;

use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\Manajemen\KlasifikasiRapatModel;
use App\Models\Manajemen\KlasifikasiSuratModel;
use App\Models\Manajemen\KlasifikasiJabatanModel;
use App\Http\Requests\Pengaturan\KlasifikasiRapatRequest;
use App\Http\Requests\Pengaturan\KlasifikasiSuratRequest;

class KlasifikasiController extends Controller
{
    public function indexKlasifikasi(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        if ($request->param == 'rapat') {
            $view = 'pengaturan.data-klasifikasi-rapat';
            $klasifikasi = KlasifikasiRapatModel::orderBy('updated_at', 'desc')->get();
        } elseif ($request->param == 'surat') {
            $view = 'pengaturan.data-klasifikasi-surat';
            $klasifikasi = KlasifikasiSuratModel::orderBy('updated_at', 'desc')->get();
        } elseif ($request->param == 'jabatan') {
            $view = 'pengaturan.data-klasifikasi-jabatan';
            $klasifikasi = KlasifikasiJabatanModel::orderBy('updated_at', 'desc')->get();
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengaturan', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Klasifikasi ' . ucfirst($request->param), 'link' => route('klasifikasi.index', ['param' => $request->param]), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengaturan | Klasifikasi ' . ucfirst($request->param),
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'klasifikasi' => $klasifikasi
        ];

        return view($view, $data);
    }

    public function formKlasifikasi(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        if ($request->klaster == 'rapat') {
            $view = 'pengaturan.form-klasifikasi-rapat';
            if ($request->id != 'null') {
                $findKlasifikasi = KlasifikasiRapatModel::findOrFail(Crypt::decrypt($request->id));
            }
        } elseif ($request->klaster == 'surat') {
            $view = 'pengaturan.form-klasifikasi-surat';
            if ($request->id != 'null') {
                $findKlasifikasi = KlasifikasiSuratModel::findOrFail(Crypt::decrypt($request->id));
            }
        } elseif ($request->klaster == 'jabatan') {
            $view = 'pengaturan.form-klasifikasi-jabatan';
            if ($request->id != 'null') {
                $findKlasifikasi = KlasifikasiJabatanModel::findOrFail(Crypt::decrypt($request->id));
            }
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchKlasifikasi = null;
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchKlasifikasi = $findKlasifikasi;
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengaturan', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Klasifikasi', 'link' => route('klasifikasi.index', ['param' => $request->klaster]), 'page' => ''],
            ['title' => $formTitle . ' Klasifikasi ' . ucfirst($request->klaster), 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Pengaturan | ' . $formTitle . ' Klasifikasi ' . ucfirst($request->klaster),
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Klasifikasi ' . ucfirst($request->klaster),
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'klasifikasi' => $searchKlasifikasi
        ];

        return view($view, $data);
    }

    public function saveKlasifikasiRapat(KlasifikasiRapatRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'rapat' => htmlspecialchars($request->input('rapat')),
            'kode_klasifikasi' => htmlspecialchars($request->input('kodeKlasifikasi')),
            'keterangan' => nl2br(htmlspecialchars($request->input('keterangan'))),
            'aktif' => htmlspecialchars($request->input('aktif')),
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            $save = KlasifikasiRapatModel::create($formData);
            $success = 'Klasifikasi Rapat berhasil di simpan !';
            $error = 'Klasifikasi Rapat gagal di simpan !';
        } elseif ($paramIncoming == 'update') {
            $search = KlasifikasiRapatModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Klasifikasi Rapat berhasil di perbarui !';
            $error = 'Klasifikasi Rapat gagal di perbarui !';
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->route('klasifikasi.index', ['param' => 'rapat'])->with('success', $success);
    }

    public function deleteKlasifikasiRapat(Request $request): RedirectResponse
    {
        // Checking data klasifikasi rapat on database
        $klasifikasiRapat = KlasifikasiRapatModel::findOrFail(Crypt::decrypt($request->id));
        if ($klasifikasiRapat) {
            $klasifikasiRapat->delete();
            return redirect()->route('klasifikasi.index', ['param' => 'rapat'])->with('success', 'Klasifikasi Rapat berhasil di hapus !');
        }
        return redirect()->route('klasifikasi.index', ['param' => 'rapat'])->with('error', 'Klasifikasi Rapat gagal di hapus !');
    }

    public function saveKlasifikasiSurat(KlasifikasiSuratRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'kode_surat' => htmlspecialchars($request->input('kodeSurat')),
            'kode_klasifikasi' => htmlspecialchars($request->input('kodeKlasifikasi')),
            'keterangan' => nl2br(htmlspecialchars($request->input('keterangan'))),
            'aktif' => htmlspecialchars($request->input('aktif')),
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            $save = KlasifikasiSuratModel::create($formData);
            $success = 'Klasifikasi Surat berhasil di simpan !';
            $error = 'Klasifikasi Surat gagal di simpan !';
        } elseif ($paramIncoming == 'update') {
            $search = KlasifikasiSuratModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Klasifikasi Surat berhasil di perbarui !';
            $error = 'Klasifikasi Surat gagal di perbarui !';
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->route('klasifikasi.index', ['param' => 'surat'])->with('success', $success);
    }

    public function deleteKlasifikasiSurat(Request $request): RedirectResponse
    {
        // Checking data klasifikasi surat on database
        $klasifikasiSurat = KlasifikasiSuratModel::findOrFail(Crypt::decrypt($request->id));
        if ($klasifikasiSurat) {
            $klasifikasiSurat->delete();
            return redirect()->route('klasifikasi.index', ['param' => 'surat'])->with('success', 'Klasifikasi Surat berhasil di hapus !');
        }
        return redirect()->route('klasifikasi.index', ['param' => 'surat'])->with('error', 'Klasifikasi Surat gagal di hapus !');
    }

    public function indexSetKode()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengaturan', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Set Nomor Rapat', 'link' => route('rapat.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengaturan | Set Nomor Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb
        ];

        return view('pengaturan.set-kode-rapat', $data);
    }
}
