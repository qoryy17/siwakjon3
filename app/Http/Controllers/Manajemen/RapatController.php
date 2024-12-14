<?php

namespace App\Http\Controllers\Manajemen;

use App\Enum\RolesEnum;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RapatController extends Controller
{
    public function indexRapat()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat Dinas', 'link' => route('rapat.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb
        ];

        return view('rapat.data-rapat', $data);
    }

    public function detailRapat(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat', 'link' => route('rapat.index'), 'page' => ''],
            ['title' => 'Detail', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Rapat | Detail Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb
        ];

        return view('rapat.detail-rapat', $data);
    }

    public function formUndangan(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $routeBack = route('rapat.index');
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $routeBack = route('rapat.index');
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat', 'link' => route('rapat.index'), 'page' => ''],
            ['title' => $formTitle . ' Rapat', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Rapat | ' . $formTitle . ' Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Rapat ' . $request->klasifikasiRapat,
            'routeBack' => $routeBack
        ];

        return view('rapat.form-undangan', $data);
    }

    public function formNotula(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $routeBack = route('rapat.detail', ['id' => 'null']);
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $routeBack = route('rapat.detail', ['id' => 'null']);
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat', 'link' => route('rapat.index'), 'page' => ''],
            ['title' => $formTitle . ' Notula', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Rapat | ' . $formTitle . ' Notula',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Notula ',
            'routeBack' => $routeBack
        ];

        return view('rapat.form-notula', $data);
    }

    public function formDokumentasi(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat', 'link' => route('rapat.index'), 'page' => ''],
            ['title' => 'Dokumentasi', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Rapat | ' . 'Dokumentasi',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => 'Dokumentasi ',
            'routeBack' => route('rapat.index')
        ];

        return view('rapat.form-dokumentasi', $data);
    }
}
