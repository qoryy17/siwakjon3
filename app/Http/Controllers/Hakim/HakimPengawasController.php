<?php

namespace App\Http\Controllers\Hakim;

use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\Hakim\HakimPengawasModel;
use App\Models\Pengaturan\UnitKerjaModel;
use App\Http\Requests\Hakim\HakimPengawasRequest;

class HakimPengawasController extends Controller
{
    public function indexDaftarHakim(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Hakim Pengawas', 'link' => route('pengawasan.daftar-hakim-pengawas'), 'page' => 'aria-current="page"']
        ];

        if ($request->input('search')) {
            $request->validate(
                ['search' => 'string'],
                ['search' => 'Kata Pencarian harus berupa karakter valid !']
            );
            $hakim = $this->getHakimPengawas($request->input('search'));
        } else {
            $hakim = HakimPengawasModel::with('pegawai')->with('unitKerja')
                ->where('aktif', '=', 'Y')->orderBy('ordering', 'asc');
        }

        $data = [
            'title' => 'Pengawasan Bidang | Daftar Hakim Pengawas',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'hakim' => $hakim,
        ];

        return view('pengawasan.daftar-hakim-pengawas', $data);
    }
    protected function getHakimPengawas($keyword)
    {
        $hakim = HakimPengawasModel::with('pegawai')->with('unitKerja')
            ->whereHas('pegawai', function ($query) use ($keyword) {
                $query->where('nip', 'like', "%$keyword%")
                    ->orWhere('nama', 'like', "%$keyword%");
            })->where('aktif', '=', 'Y')->orderBy('ordering', 'asc');

        return $hakim;
    }

    public function indexHakimPengawas()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $hakim = HakimPengawasModel::with('pegawai')->with('unitKerja')->orderBy('ordering', 'asc')->get();

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
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !')->withInput();
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
            'hakimPengawas' => PegawaiModel::with('jabatan')
                ->whereHas('jabatan', function ($query) {
                    $query->where('jabatan', '=', 'Hakim');
                })->orderBy('nip', 'desc')->get(),
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
            'ordering' => htmlspecialchars($request->input('ordering')),
        ];

        // Is Hakim ?
        $hakim = PegawaiModel::with('jabatan')->findOrFail($formData['pegawai_id']);
        if ($hakim && $hakim->jabatan->jabatan != 'Hakim') {
            return redirect()->back()->with('error', 'Hanya jabatan hakim yang di perbolehkan sebagai pengawas !')->withInput();
        }

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            $save = HakimPengawasModel::create($formData);
            $success = 'Hakim Pengawas berhasil di simpan !';
            $error = 'Hakim Pengawas gagal di simpan !';
            $activity = 'Menambahkan hakim pengawas : ' . $hakim->nama;
        } elseif ($paramIncoming == 'update') {
            $search = HakimPengawasModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Hakim Pengawas berhasil di perbarui !';
            $error = 'Hakim Pengawas gagal di perbarui !';
            $activity = 'Memperbarui hakim pengawas : ' . $hakim->nama;
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !')->withInput();
        }

        if (!$save) {
            return redirect()->back()->with('error', $error)->withInput();
        }

        // Saving logs activity
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->route('pengguna.hakim-pengawas')->with('success', $success);
    }

    public function delete(Request $request): RedirectResponse
    {
        // Checking data hakim on database
        $hakim = HakimPengawasModel::findOrFail(Crypt::decrypt($request->id));
        if ($hakim) {
            // Saving logs activity
            $activity = 'Menghapus hakim pengawas dengan pegawai id : ' . $hakim->pegawai_id;
            \App\Services\LogsService::saveLogs($activity);
            $hakim->delete();
            return redirect()->route('pengguna.hakim-pengawas')->with('success', 'Hakim Pengawas berhasil di hapus !');
        }
        return redirect()->route('pengguna.hakim-pengawas')->with('error', 'Hakim Pengawas gagal di hapus !');
    }
}
