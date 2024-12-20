<?php

namespace App\Http\Controllers\Manajemen;

use App\Helpers\RouteLink;
use App\Helpers\TimeSession;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\Manajemen\DetailRapatModel;
use App\Models\Pengaturan\SetKodeRapatModel;
use App\Models\Manajemen\ManajemenRapatModel;
use App\Models\Pengguna\PejabatPenggantiModel;
use App\Models\Manajemen\KlasifikasiRapatModel;
use App\Models\Manajemen\KlasifikasiJabatanModel;
use App\Http\Requests\Manajemen\FormManajemenRapat;
use App\Http\Requests\Manajemen\FormUndanganRapatRequest;

class RapatController extends Controller
{
    public function indexRapat()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat Dinas', 'link' => route('rapat.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'klasifikasiRapat' => KlasifikasiRapatModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'klasifikasiJabatan' => KlasifikasiJabatanModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
        ];

        return view('rapat.data-rapat', $data);
    }

    public function detailRapat(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat', 'link' => route('rapat.index'), 'page' => ''],
            ['title' => 'Detail', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Rapat | Detail Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb
        ];

        return view('rapat.detail-rapat', $data);
    }

    public function formUndangan(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $routeBack = route('rapat.index');
            $rapat = null;
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $routeBack = route('rapat.index');
            $rapat = ManajemenRapatModel::with('detailRapat')->findOrFail(Crypt::decrypt($request->id));
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $klasifikasiRapat = KlasifikasiRapatModel::findOrFail($request->input('klasifikasiRapat'));
        if (!$klasifikasiRapat) {
            return redirect()->back()->with('error', 'Klasifikasi Rapat tidak ditemukan !');
        }

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat', 'link' => route('rapat.index'), 'page' => ''],
            ['title' => $formTitle . ' Rapat', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Rapat | ' . $formTitle . ' Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Rapat ' . $klasifikasiRapat->rapat,
            'routeBack' => $routeBack,
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'pejabatPengganti' => PejabatPenggantiModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'pegawai' => PegawaiModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'rapat' => $rapat
        ];

        return view('rapat.form-undangan', $data);
    }

    public function save(FormManajemenRapat $request, FormUndanganRapatRequest $requestRapat): RedirectResponse
    {
        // Run validated
        $request->validated();
        $requestRapat->validated();

        // Generate index nomor dokumen rapat
        $indexNumber = ManajemenRapatModel::orderBy('nomor_indeks', 'desc')->first();
        $indexIncrement = intval($indexNumber) + 1;

        $searchKodeSurat = SetKodeRapatModel::first();
        if (!$searchKodeSurat) {
            return redirect()->back()->with('error', 'Kode Surat belum di set !');
        }

        $nomorDokumen = $indexIncrement . '' . 'W2-U4' . $searchKodeSurat->kode_rapat_dinas . '/' . TimeSession::convertMonthToRoman() . '/' . date('Y');

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;
        $saveDetailRapat = null;

        if ($paramIncoming == 'save') {

            $formData = [
                'kode_rapat' => Str::uuid(),
                'nomor_indeks' => $indexIncrement,
                'nomor_dokumen' => $nomorDokumen,
                'pegawai_id' => htmlspecialchars($request->input('pegawai')),
                'unit_kerja_id' => htmlspecialchars($request->input('unitKerja')),
                'aktif' => htmlspecialchars($request->input('aktif')),
            ];
            try {
                DB::beginTransaction();
                $save = ManajemenRapatModel::create($formData);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', $th);
            }
            $success = 'Dokumen Rapat berhasil di simpan !';
            $error = 'Dokumen Rapat gagal di simpan !';
        } elseif ($paramIncoming == 'update') {
            $search = ManajemenRapatModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Dokumen Rapat berhasil di perbarui !';
            $error = 'Dokumen Rapat gagal di perbarui !';
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->route('rapat.index')->with('success', $success);
    }

    public function delete(Request $request): RedirectResponse
    {
        // Checking data manajemen rapat on database
        $rapat = ManajemenRapatModel::findOrFail(Crypt::decrypt($request->id));
        if ($rapat) {
            $detailRapat = DetailRapatModel::where('manajemen_rapat_id', '=', $rapat->id);
            if ($detailRapat) {
                $detailRapat->delete();
            }
            $rapat->delete();
            return redirect()->route('rapat.index')->with('success', 'Rapat berhasil di hapus !');
        }
        return redirect()->route('rapat.index')->with('error', 'Rapat gagal di hapus !');
    }

    public function formNotula(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $routeBack = route('rapat.detail', ['id' => 'null']);
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $routeBack = route('rapat.detail', ['id' => 'null']);
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat', 'link' => route('rapat.index'), 'page' => ''],
            ['title' => $formTitle . ' Notula', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Rapat | ' . $formTitle . ' Notula',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Notula ',
            'routeBack' => $routeBack
        ];

        return view('rapat.form-notula', $data);
    }

    public function formDokumentasi(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat', 'link' => route('rapat.index'), 'page' => ''],
            ['title' => 'Dokumentasi', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Rapat | ' . 'Dokumentasi',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => 'Dokumentasi ',
            'routeBack' => route('rapat.index')
        ];

        return view('rapat.form-dokumentasi', $data);
    }
}
