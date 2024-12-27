<?php

namespace App\Http\Controllers\Pengaturan;

use Carbon\Carbon;
use App\Enum\RolesEnum;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengaturan\LogsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LogsController extends Controller
{
    public function indexLogs()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengaturan Aplikasi', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Logs', 'link' => route('aplikasi.pengembang'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengaturan Aplikasi | Logs',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'logs' => LogsModel::with('user')->orderBy('created_at', 'desc')->get(),
        ];

        return view('aplikasi.data-logs', $data);
    }

    public function deleteLogs(Request $request): RedirectResponse
    {
        // Run validated
        $request->validate([
            'tanggalAwal' => 'required|date_format:m/d/Y',
            'tanggalAkhir' => 'required|date_format:m/d/Y|after_or_equal:tanggalAwal',
        ], [
            'tanggalAwal.required' => 'Tanggal awal harus di pilih !',
            'tanggalAwal.string' => 'Tanggal awal harus berupa karakter valid !',
            'tanggalAkhir.required' => 'Tanggal awal harus di pilih !',
            'tanggalAkhir.string' => 'Tanggal awal harus berupa karakter valid !',
        ]);

        $tanggalAwal = Carbon::createFromFormat('m/d/Y', htmlentities($request->input('tanggalAwal')))->startOfDay();
        $tanggalAkhir = Carbon::createFromFormat('m/d/Y', htmlentities($request->input('tanggalAkhir')))->endOfDay();

        $deleteLogs = LogsModel::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);

        if ($deleteLogs->exists()) {
            return redirect()->route('aplikasi.logs')->with('success', 'Logs berhasil di hapus !');
        }
        return redirect()->route('aplikasi.logs')->with('error', 'Logs tidak di temukan !');
    }
}
