<?php

namespace App\Http\Controllers\Manajemen;

use App\Helpers\Query;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaturan\AplikasiModel;
use App\Models\Manajemen\PengawasanBidangModel;
use App\Models\Manajemen\TemuanWasbidModel;

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


        if ($request->input('search')) {
            $parameter = [
                'search' => htmlspecialchars($request->input('search')),
                'year' => htmlspecialchars($request->input('tahun')),
            ];
            $resultSearch = $this->searchData($parameter);
        } else {
            $resultSearch = null;
        }

        $data = [
            'title' => 'Pengawasan Bidang | Monitoring Pengawasan',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'aplikasi' => AplikasiModel::first(),
            'objekPengawasan' => Query::objekPengawasan(),
            'result' => $resultSearch
        ];

        return view('pengawasan.monitoring', $data);
    }

    private function searchData($parameter = null)
    {
        if ($parameter == null) {
            return redirect()->route('monitoring.index')->with('error', 'Invalid parameter !');
        }

        // Search data temuan
        $objek = $parameter['search'];
        $tahun = $parameter['year'];

        $temuan = TemuanWasbidModel::where('objek_pengawasan', '=', $objek)->whereYear('created_at', $tahun)->orderBy('created_at', 'asc');
        if (!$temuan->exists()) {
            return 'Not Found';
        }

        $countTemuan = TemuanWasbidModel::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->where('objek_pengawasan', '=', $objek)
            ->whereYear('created_at', $tahun)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $total = TemuanWasbidModel::where('objek_pengawasan', '=', $objek)->whereYear('created_at', $tahun)->count();

        // Format result to array, if data on month not available set to 0
        $pengawasanResult = [];
        for ($month = 1; $month <= 12; $month++) {
            $pengawasanResult[] = $countTemuan[$month] ?? 0;
        }

        $result = [
            'objek' => $objek,
            'tahun' => $tahun,
            'totalTemuan' => $total,
            'barChart' => $pengawasanResult,
            'temuan' => $temuan->get(),
        ];

        return $result;
    }
}
