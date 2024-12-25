<?php

namespace App\Http\Controllers\Hakim;

use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hakim\HakimPengawasRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\Hakim\HakimPengawasModel;
use App\Models\Pengaturan\UnitKerjaModel;

class HakimPengawasController extends Controller
{
    public function indexDaftarHakim()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Hakim Pengawas', 'link' => route('pengawasan.daftar-hakim-pengawas'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Pengawasan Bidang | Daftar Hakim Pengawas',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb
        ];

        return view('pengawasan.daftar-hakim-pengawas', $data);
    }

    public function indexHakimPengawas()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $hakim = HakimPengawasModel::with('pegawai')->with('unitKerja')->orderBy('sw_hakim_pengawas.created_at', 'desc')->get();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengguna', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Hakim Pengawas', 'link' => route('pengguna.hakim-pengawas'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Pengguna | Hakim Pengawas',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'hakim' => $hakim
        ];

        return view('pengguna.data-hakim-pengawas', $data);
    }

    public function formHakimPengawas(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchHakim = null;
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchHakim = HakimPengawasModel::findOrFail(Crypt::decrypt($request->id));
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengguna', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Hakim Pengawas', 'link' => route('pengguna.hakim-pengawas'), 'page' => ''],
            ['title' => $formTitle . ' Hakim Pengawas', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Pengguna | ' . $formTitle . ' Hakim Pengawas',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Hakim Pengawas',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'hakim' => $searchHakim,
            'pegawai' => PegawaiModel::where('aktif', '=', 'Y')->orderBy('nip', 'desc')->get(),
            'unitKerja' => UnitKerjaModel::where('aktif', '=', 'Y')->orderBy('unit_kerja', 'asc')->get()
        ];

        return view('pengguna.form-hakim-pengawas', $data);
    }

    public function save(HakimPengawasRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'pegawai_id' => htmlspecialchars($request->input('pegawai')),
            'unit_kerja_id' => htmlspecialchars($request->input('unitKerja')),
            'aktif' => htmlspecialchars($request->input('aktif')),
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            $save = HakimPengawasModel::create($formData);
            $success = 'Hakim Pengawas berhasil di simpan !';
            $error = 'Hakim Pengawas gagal di simpan !';
        } elseif ($paramIncoming == 'update') {
            $search = HakimPengawasModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Hakim Pengawas berhasil di perbarui !';
            $error = 'Hakim Pengawas gagal di perbarui !';
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->route('pengguna.hakim-pengawas')->with('success', $success);
    }

    public function delete(Request $request): RedirectResponse
    {
        // Checking data hakim on database
        $hakim = HakimPengawasModel::findOrFail(Crypt::decrypt($request->id));
        if ($hakim) {
            $hakim->delete();
            return redirect()->route('pengguna.hakim-pengawas')->with('success', 'Hakim Pengawas berhasil di hapus !');
        }
        return redirect()->route('pengguna.hakim-pengawas')->with('error', 'Hakim Pengawas gagal di hapus !');
    }
}
