<?php

namespace App\Http\Controllers;

use App\Helpers\QueryHelper;
use App\Helpers\RouteLink;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function monitoringRapat()
    {
        $route = RouteLink::homeString(Auth::user()->roles);
        $routeHome = RouteLink::homePage(Auth::user()->roles);
        if (Auth::user()->roles !== \App\Enum\RolesEnum::SUPERADMIN->value) {
            return redirect()->route($route)->with('error', 'Akses kamu dilarang pada halaman ini !');
        }

        $breadcumb = [
            ['title' => 'Home', 'link' => $routeHome, 'page' => ''],
            ['title' => 'Dashboard', 'link' => $routeHome, 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => env('APP_NAME') . ' | ' . 'Monitoring Rapat',
            'routeHome' => $routeHome,
            'breadcumbs' => $breadcumb,
            'rapat' => QueryHelper::getMonitoringRapat()
        ];

        return view('monitoring.data-monitoring-rapat', $data);
    }
}
