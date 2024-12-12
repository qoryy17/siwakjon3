<?php

namespace App\Http\Controllers\Arsip;

use App\Enum\RolesEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuratKeputusanController extends Controller
{
    public function indexArsipSK()
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
}
