<?php

namespace App\Http\Controllers\Hakim;

use App\Enum\RolesEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HakimPengawasController extends Controller
{
    public function indexDaftarHakim()
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
            ['title' => 'Hakim Pengawas', 'link' => route('pengawasan.daftar-hakim-pengawas'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Pengawasan Bidang | Daftar Hakim Pengawas',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('pengawasan.daftar-hakim-pengawas', $data);
    }

    public function indexHakimPengawas()
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
            ['title' => 'Manajemen Pengguna', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Hakim Pengawas', 'link' => route('pengguna.hakim-pengawas'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengguna | Hakim Pengawas',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('pengguna.data-hakim-pengawas', $data);
    }
}
