<?php

namespace App\Http\Controllers\Manajemen;

use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\Pengaturan\SetKodeRapatModel;
use App\Models\Manajemen\KlasifikasiRapatModel;
use App\Models\Manajemen\KlasifikasiSuratModel;
use App\Models\Manajemen\KlasifikasiJabatanModel;
use App\Http\Requests\Pengaturan\KodeRapatRequest;
use App\Http\Requests\Pengaturan\KlasifikasiRapatRequest;
use App\Http\Requests\Pengaturan\KlasifikasiSuratRequest;
use App\Http\Requests\Pengaturan\KlasifikasiJabatanRequest;

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
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !')->withInput();
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
            $activity = 'Menambahkan klasifikasi rapat : ' . $formData['rapat'];
        } elseif ($paramIncoming == 'update') {
            $search = KlasifikasiRapatModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Klasifikasi Rapat berhasil di perbarui !';
            $error = 'Klasifikasi Rapat gagal di perbarui !';
            $activity = 'Memperbarui klasifikasi rapat : ' . $formData['rapat'];
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !')->withInput();
        }

        if (!$save) {
            return redirect()->back()->with('error', $error)->withInput();
        }

        // Saving logs activity
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->route('klasifikasi.index', ['param' => 'rapat'])->with('success', $success);
    }

    public function deleteKlasifikasiRapat(Request $request): RedirectResponse
    {
        // Checking data klasifikasi rapat on database
        $klasifikasiRapat = KlasifikasiRapatModel::findOrFail(Crypt::decrypt($request->id));
        if ($klasifikasiRapat) {
            // Saving logs activity
            $activity = 'Menghapus klasifikasi rapat : ' . $klasifikasiRapat->rapat;
            \App\Services\LogsService::saveLogs($activity);
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
            $activity = 'Menambahkan klasifikasi kode surat : ' . $formData['kode_surat'];
        } elseif ($paramIncoming == 'update') {
            $search = KlasifikasiSuratModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Klasifikasi Surat berhasil di perbarui !';
            $error = 'Klasifikasi Surat gagal di perbarui !';
            $activity = 'Memperbarui klasifikasi kode surat : ' . $formData['kode_surat'];
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !')->withInput();
        }

        if (!$save) {
            return redirect()->back()->with('error', $error)->withInput();
        }

        // Saving logs activity
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->route('klasifikasi.index', ['param' => 'surat'])->with('success', $success);
    }

    public function deleteKlasifikasiSurat(Request $request): RedirectResponse
    {
        // Checking data klasifikasi surat on database
        $klasifikasiSurat = KlasifikasiSuratModel::findOrFail(Crypt::decrypt($request->id));
        if ($klasifikasiSurat) {
            // Saving logs activity
            $activity = 'Menghapus klasifikasi kode surat : ' . $klasifikasiSurat->kode_surat;
            \App\Services\LogsService::saveLogs($activity);
            $klasifikasiSurat->delete();
            return redirect()->route('klasifikasi.index', ['param' => 'surat'])->with('success', 'Klasifikasi Surat berhasil di hapus !');
        }
        return redirect()->route('klasifikasi.index', ['param' => 'surat'])->with('error', 'Klasifikasi Surat gagal di hapus !');
    }

    public function saveKlasifikasiJabatan(KlasifikasiJabatanRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'jabatan' => htmlspecialchars($request->input('jabatan')),
            'kode_jabatan' => htmlspecialchars($request->input('kodeJabatan')),
            'keterangan' => nl2br(htmlspecialchars($request->input('keterangan'))),
            'aktif' => htmlspecialchars($request->input('aktif')),
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            $save = KlasifikasiJabatanModel::create($formData);
            $success = 'Klasifikasi Jabatan berhasil di simpan !';
            $error = 'Klasifikasi Jabatan gagal di simpan !';
            $activity = 'Menambahkan klasifikasi jabatan : ' . $formData['jabatan'];
        } elseif ($paramIncoming == 'update') {
            $search = KlasifikasiJabatanModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Klasifikasi Jabatan berhasil di perbarui !';
            $error = 'Klasifikasi Jabatan gagal di perbarui !';
            $activity = 'Memperbarui klasifikasi jabatan : ' . $formData['jabatan'];
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !')->withInput();
        }

        if (!$save) {
            return redirect()->back()->with('error', $error)->withInput();
        }

        // Saving logs activity
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->route('klasifikasi.index', ['param' => 'jabatan'])->with('success', $success);
    }

    public function deleteKlasifikasiJabatan(Request $request): RedirectResponse
    {
        // Checking data klasifikasi jabatan on database
        $klasifikasiJabatan = KlasifikasiJabatanModel::findOrFail(Crypt::decrypt($request->id));
        if ($klasifikasiJabatan) {
            // Saving logs activity
            $activity = 'Menghapus klasifikasi jabatan : ' . $klasifikasiJabatan->jabatan;
            \App\Services\LogsService::saveLogs($activity);
            $klasifikasiJabatan->delete();
            return redirect()->route('klasifikasi.index', ['param' => 'jabatan'])->with('success', 'Klasifikasi Jabatan berhasil di hapus !');
        }
        return redirect()->route('klasifikasi.index', ['param' => 'jabatan'])->with('error', 'Klasifikasi Jabatan gagal di hapus !');
    }

    public function indexSetKode()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengaturan', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Set Nomor Rapat', 'link' => route('klasifikasi.set-kode'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengaturan | Set Nomor Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'kodeRapat' => KlasifikasiSuratModel::where('aktif', '=', 'Y')->orderBy('updated_at', 'desc')->get(),
            'setKode' => SetKodeRapatModel::orderBy('updated_at', 'desc')->first()
        ];

        return view('pengaturan.set-kode-rapat', $data);
    }

    public function saveKodeRapat(KodeRapatRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'kode_rapat_dinas' => htmlspecialchars($request->input('rapatDinas')),
            'kode_pengawasan' => htmlspecialchars($request->input('rapatPengawasan')),
        ];

        $save = null;

        $kodeRapat = SetKodeRapatModel::first();
        if ($kodeRapat) {
            $kodeRapat->delete();
            $kodeRapat->truncate();
        } else {
            $save = SetKodeRapatModel::create($formData);
        }

        if (!$save) {
            return redirect()->route('klasifikasi.set-kode')->with('error', 'Set Kode Rapat gagal !')->withInput();
        }

        // Saving logs activity
        $activity = 'Mengatur kode rapat';
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->route('klasifikasi.set-kode')->with('success', 'Set Kode Rapat berhasil !');
    }
}
