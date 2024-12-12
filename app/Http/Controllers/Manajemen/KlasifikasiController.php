<?php

namespace App\Http\Controllers\Manajemen;

use App\Enum\RolesEnum;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class KlasifikasiController extends Controller
{
    public function indexKlasifikasi(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage();

        if ($request->param == 'rapat') {
            $view = 'pengaturan.data-klasifikasi-rapat';
        } elseif ($request->param == 'surat') {
            $view = 'pengaturan.data-klasifikasi-surat';
        } elseif ($request->param == 'jabatan') {
            $view = 'pengaturan.data-klasifikasi-jabatan';
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
            'breadcumbs' => $breadcumb
        ];

        return view($view, $data);
    }

    public function indexSetKode()
    {
        // Redirect home page for role
        $route = RouteLink::homePage();

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

    public function formKlasifikasi(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage();

        if ($request->klaster == 'rapat') {
            $view = 'pengaturan.form-klasifikasi-rapat';
        } elseif ($request->klaster == 'surat') {
            $view = 'pengaturan.form-klasifikasi-surat';
        } elseif ($request->klaster == 'jabatan') {
            $view = 'pengaturan.form-klasifikasi-jabatan';
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
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
            'formTitle' => $formTitle . ' Klasifikasi ' . ucfirst($request->klaster)
        ];

        return view($view, $data);
    }
}
