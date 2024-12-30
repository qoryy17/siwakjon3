<?php

namespace App\Http\Controllers\Manajemen;

use App\Helpers\RouteLink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hakim\HakimPengawasModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\Pengaturan\UnitKerjaModel;
use App\Models\Manajemen\KunjunganPengawasanModel;

class KunjunganController extends Controller
{
    public function indexKunjungan()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $kunjungan = KunjunganPengawasanModel::with('detailKunjungan')->orderBy('created_at', 'desc')->get();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Kunjungan Pengawasan', 'link' => route('pengawasan.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengawasan Bidang',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'kunjungan' => $kunjungan
        ];

        return view('pengawasan.data-kujungan-pengawasan', $data);
    }

    public function formKunjungan(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchKunjungan = null;
            $kodeKunjungan = Str::uuid();
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchKunjungan = KunjunganPengawasanModel::findOrFail(Crypt::decrypt($request->id));
            $kodeKunjungan = $searchKunjungan->kode_kunjungan;
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Kunjungan Pengawasan', 'link' => route('kunjungan.index'), 'page' => ''],
            ['title' => $formTitle . ' Kunjungan Pengawasan', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengawasan Bidang | ' . $formTitle . ' Kunjungan Pengawasan',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Kunjungan Pengawasan',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'kunjungan' => $searchKunjungan,
            'unitKerja' => UnitKerjaModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'kodeKunjungan' => $kodeKunjungan
        ];

        return view('pengawasan.form-kunjungan', $data);
    }

    public function detailKunjungan()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $hakim = HakimPengawasModel::with('pegawai')->whereHas('pegawai', function ($query) {
            $query->orderBy('nama', 'asc');
        })->get();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Kunjungan Pengawasan', 'link' => route('kunjungan.index'), 'page' => ''],
            ['title' => 'Detail', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengawasan Bidang | Detail Kunjungan Pengawasan',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'hakim' => $hakim
        ];

        return view('pengawasan.detail-kunjungan', $data);
    }
}
