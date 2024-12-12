<?php

namespace App\Http\Controllers\Pengaturan;

use App\Enum\RolesEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogsController extends Controller
{
    public function indexLogs()
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
            ['title' => 'Logs', 'link' => route('aplikasi.pengembang'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengaturan Aplikasi | Logs',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb
        ];

        return view('aplikasi.data-logs', $data);
    }
}
