<?php

namespace App\Http\Controllers\Penggguna;

use App\Enum\RolesEnum;
use App\Helpers\RouteLink;
use App\Helpers\TimeSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class PenggunaController extends Controller
{
    public function indexAkunPengguna()
    {
        // Redirect home page for role
        $route = RouteLink::homePage();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengguna', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Akun Pengguna', 'link' => route('pengguna.akun'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengguna | Akun Pengguna',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb
        ];

        return view('pengguna.data-akun', $data);
    }

    public function formAkunPengguna(Request $request)
    {
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

        // Redirect home page for role
        $route = RouteLink::homePage();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengguna', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Akun Pengguna', 'link' => route('pengguna.akun'), 'page' => ''],
            ['title' => $formTitle . ' Pengguna', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Pengguna | ' . $formTitle . ' Pengguna',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Pengguna'
        ];

        return view('pengguna.form-akun', $data);
    }

    public function indexPegawai()
    {
        // Redirect home page for role
        $route = RouteLink::homePage();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengguna', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Pegawai', 'link' => route('pengguna.pegawai'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengguna | Pegawai',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('pengguna.data-pegawai', $data);
    }

    public function formPegawai(Request $request)
    {
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

        // Redirect home page for role
        $route = RouteLink::homePage();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengguna', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Pegawai', 'link' => route('pengguna.pegawai'), 'page' => ''],
            ['title' => $formTitle . ' Pegawai', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Pengguna | ' . $formTitle . ' Pegawai',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Pegawai'
        ];

        return view('pengguna.form-pegawai', $data);
    }
}
