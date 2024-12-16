<?php

namespace App\Http\Controllers\Manajemen;

use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manajemen\KlasifikasiJabatanModel;
use App\Models\Manajemen\KlasifikasiRapatModel;
use App\Models\Manajemen\KlasifikasiSuratModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

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
