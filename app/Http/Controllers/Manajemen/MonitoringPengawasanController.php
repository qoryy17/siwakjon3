<?php

namespace App\Http\Controllers\Manajemen;

use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengaturan\AplikasiModel;
use Illuminate\Support\Facades\Auth;

class MonitoringPengawasanController extends Controller
{
    public function indexMonitoring(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Monitoring Pengawasan', 'link' => route('monitoring.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengawasan Bidang | Monitoring Pengawasan',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'aplikasi' => AplikasiModel::first()
        ];

        return view('pengawasan.monitoring', $data);
    }
}
