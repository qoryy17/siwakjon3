<?php

namespace App\Http\Controllers;

use App\Enum\RolesEnum;
use App\Helpers\TimeSession;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function berandaSuperadmin()
    {
        $breadcumb = [
            ['title' => 'Home', 'link' => route('home.superadmin'), 'page' => ''],
            ['title' => 'Dashboard', 'link' => route('home.superadmin'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => env('APP_NAME') . ' | ' . 'Dashboard',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb,
            'welcome' => 'Selamat ' . TimeSession::istime() . ', Qori Chairawan'
        ];

        return view('home.home-superadmin', $data);
    }

    public function berandaAdmin()
    {
        $breadcumb = [
            ['title' => 'Home', 'link' => route('home.administrator'), 'page' => ''],
            ['title' => 'Dashboard', 'link' => route('home.administrator'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => env('APP_NAME') . ' | ' . 'Dashboard',
            'routeHome' => route('home.administrator'),
            'breadcumbs' => $breadcumb,
            'welcome' => 'Selamat ' . TimeSession::istime() . ', Qori Chairawan'
        ];

        return view('home.home-admin', $data);
    }

    public function berandaUser()
    {
        $breadcumb = [
            ['title' => 'Home', 'link' => route('home.user'), 'page' => ''],
            ['title' => 'Dashboard', 'link' => route('home.user'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => env('APP_NAME') . ' | ' . 'Dashboard',
            'routeHome' => route('home.user'),
            'breadcumbs' => $breadcumb,
            'welcome' => 'Selamat ' . TimeSession::istime() . ', Qori Chairawan'
        ];

        return view('home.home-user', $data);
    }

    public function version()
    {
        if (RolesEnum::SUPERADMIN->value == 'Superadmin') {
            $route = route('home.superadmin');
        } elseif (RolesEnum::SUPERADMIN->value == 'Administrator') {
            $route = route('home.administrator');
        } else {
            $route = route('home.user');
        }

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Dashboard', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Version', 'link' => route('home.version'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => env('APP_NAME') . ' | Version',
            'routeHome' => route('home.user'),
            'breadcumbs' => $breadcumb
        ];

        return view('aplikasi.version', $data);
    }

    public function logs()
    {
        if (RolesEnum::SUPERADMIN->value == 'Superadmin') {
            $route = route('home.superadmin');
        } elseif (RolesEnum::SUPERADMIN->value == 'Administrator') {
            $route = route('home.administrator');
        } else {
            $route = route('home.user');
        }

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Dashboard', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Logs', 'link' => route('home.logs'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => env('APP_NAME') . ' | Logs',
            'routeHome' => route('home.user'),
            'breadcumbs' => $breadcumb
        ];

        return view('aplikasi.logs', $data);
    }

    public function pintasanRapat()
    {
        if (RolesEnum::SUPERADMIN->value == 'Superadmin') {
            $route = route('home.superadmin');
        } elseif (RolesEnum::SUPERADMIN->value == 'Administrator') {
            $route = route('home.administrator');
        } else {
            $route = route('home.user');
        }

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat Dinas', 'link' => route('rapat.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Rapat | Rapat Saya',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('rapat.data-rapat', $data);
    }

    public function pintasanPengawasan()
    {
        if (RolesEnum::SUPERADMIN->value == 'Superadmin') {
            $route = route('home.superadmin');
        } elseif (RolesEnum::SUPERADMIN->value == 'Administrator') {
            $route = route('home.administrator');
        } else {
            $route = route('home.user');
        }

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat Pengawasan', 'link' => route('pengawasan.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Pengawasan Bidang | Rapat Saya',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('pengawasan.data-rapat-pengawasan', $data);
    }

    public function pintasanMonev()
    {
        if (RolesEnum::SUPERADMIN->value == 'Superadmin') {
            $route = route('home.superadmin');
        } elseif (RolesEnum::SUPERADMIN->value == 'Administrator') {
            $route = route('home.administrator');
        } else {
            $route = route('home.user');
        }

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Monev', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Laporan Monev', 'link' => route('monev.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Monev | Laporan Monev Saya',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('monev.data-monev', $data);
    }

    public function pintasanSK()
    {
        if (RolesEnum::SUPERADMIN->value == 'Superadmin') {
            $route = route('home.superadmin');
        } elseif (RolesEnum::SUPERADMIN->value == 'Administrator') {
            $route = route('home.administrator');
        } else {
            $route = route('home.user');
        }

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Arsip', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Surat Keputusan', 'link' => route('pengawasan.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Arsip | Surat Keputusan',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('arsip.data-surat-keputusan', $data);
    }

    public function notifikasi()
    {
        if (RolesEnum::SUPERADMIN->value == 'Superadmin') {
            $route = route('home.superadmin');
        } elseif (RolesEnum::SUPERADMIN->value == 'Administrator') {
            $route = route('home.administrator');
        } else {
            $route = route('home.user');
        }

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Notifikasi', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Pesan Masuk', 'link' => route('pengawasan.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Notifikasi | Pesan Masuk',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('aplikasi.notifikasi', $data);
    }
}
