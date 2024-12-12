<?php

namespace App\Http\Controllers\Pengaturan;

use App\Enum\RolesEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AplikasiController extends Controller
{
    public function indexKonfigurasi()
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
            ['title' => 'Pengaturan Aplikasi', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Konfigurasi', 'link' => route('aplikasi.konfigurasi'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengaturan Aplikasi | Konfigurasi',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('aplikasi.konfigurasi', $data);
    }
}
