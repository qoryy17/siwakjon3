<?php

namespace App\Http\Controllers\Arsip;

use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\Arsip\PeriodeMonevModel;
use App\Http\Requests\Monev\PeriodeMonevRequest;

class MonevController extends Controller
{
    public function indexMonev()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

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
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Monev', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Periode Monev', 'link' => route('monev.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Monev | Periode Monev',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb,
            'periodeMonev' => PeriodeMonevModel::orderBy('created_at', 'desc')->get()
        ];

        return view('monev.data-periode-monev', $data);
    }

    public function formPeriodeMonev(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchPeriodeMonev = null;
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchPeriodeMonev = PeriodeMonevModel::findOrFail(Crypt::decrypt($request->id));
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Monev', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Periode Monev', 'link' => route('monev.periode'), 'page' => ''],
            ['title' => $formTitle . ' Periode Monev', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Monev | ' . $formTitle . ' Periode Monev',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Periode Monev',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'periode' => $searchPeriodeMonev
        ];

        return view('monev.form-periode-monev', $data);
    }

    public function savePeriodeMonev(PeriodeMonevRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'periode' => htmlspecialchars($request->input('periode')),
            'aktif' => htmlspecialchars($request->input('aktif')),
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            $save = PeriodeMonevModel::create($formData);
            $success = 'Periode Monev berhasil di simpan !';
            $error = 'Periode Monev gagal di simpan !';
        } elseif ($paramIncoming == 'update') {
            $search = PeriodeMonevModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Periode Monev berhasil di perbarui !';
            $error = 'Periode Monev gagal di perbarui !';
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->route('monev.periode')->with('success', $success);
    }

    public function deletePeriodeMonev(Request $request): RedirectResponse
    {
        // Checking data periode monev on database
        $periodeMonev = PeriodeMonevModel::findOrFail(Crypt::decrypt($request->id));
        if ($periodeMonev) {
            $periodeMonev->delete();
            return redirect()->route('monev.periode')->with('success', 'Periode Monev berhasil di hapus !');
        }
        return redirect()->route('monev.periode')->with('error', 'Periode Monev gagal di hapus !');
    }
}
