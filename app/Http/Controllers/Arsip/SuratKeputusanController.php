<?php

namespace App\Http\Controllers\Arsip;

use App\Helpers\RouteLink;
use App\Models\Arsip\ArsipSuratKeputusanModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SuratKeputusanController extends Controller
{
    public function indexArsipSK()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Arsip', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Surat Keputusan', 'link' => route('pengawasan.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Arsip | Surat Keputusan',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb,
            'arsipSK' => ArsipSuratKeputusanModel::orderBy('created_at', 'desc')->get(),
        ];

        return view('arsip.data-surat-keputusan', $data);
    }

    public function formArsipSK(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchArsipSK = null;
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchArsipSK = ArsipSuratKeputusanModel::findOrFail(Crypt::decrypt($request->id));
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Arsip', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Surat Keputusan', 'link' => route('arsip.surat-keputusan'), 'page' => ''],
            ['title' => $formTitle . ' Surat Keputusan', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Arsip | ' . $formTitle . ' Surat Keputusan',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Surat Keputusan',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'arsipSK' => $searchArsipSK
        ];

        return view('arsip.form-surat-keputusan', $data);
    }
}
