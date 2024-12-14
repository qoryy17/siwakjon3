<?php

namespace App\Http\Controllers\Pengaturan;

use App\Enum\RolesEnum;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class DevelopmentController extends Controller
{
    public function indexCatatanPengembang()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengaturan Aplikasi', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Catatan Pengembang', 'link' => route('aplikasi.pengembang'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengaturan Aplikasi | Catatan Pengembang',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('aplikasi.data-catatan-pengembang', $data);
    }

    public function formCatatanPengembang(Request $request)
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
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengaturan Aplikasi', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Catatan Pengembang', 'link' => route('aplikasi.pengembang'), 'page' => ''],
            ['title' => $formTitle . ' Catatan Pengembang', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengaturan Aplikasi | ' . $formTitle . ' Catatan Pengembang',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Catatan Pengembang'
        ];

        return view('aplikasi.form-catatan-pengembang', $data);
    }

    public function indexVersion()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengaturan Aplikasi', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Version', 'link' => route('aplikasi.pengembang'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengaturan Aplikasi | Version',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('aplikasi.data-versi', $data);
    }

    public function formVersion(Request $request)
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
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengaturan Aplikasi', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Version', 'link' => route('aplikasi.version'), 'page' => ''],
            ['title' => $formTitle . ' Version', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengaturan Aplikasi | ' . $formTitle . ' Version',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Version'
        ];

        return view('aplikasi.form-versi', $data);
    }
}
