<?php

namespace App\Http\Controllers\Arsip;

use App\Enum\RolesEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MonevController extends Controller
{
    public function indexMonev()
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
            'title' => 'Manajemen Monev | Laporan Monev',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('monev.data-monev', $data);
    }

    public function indexPeriodeMonev()
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
            ['title' => 'Periode Monev', 'link' => route('monev.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Monev | Periode Monev',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('monev.data-periode-monev', $data);
    }
}
