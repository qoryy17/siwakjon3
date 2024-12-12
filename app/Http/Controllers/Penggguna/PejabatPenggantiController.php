<?php

namespace App\Http\Controllers\Penggguna;

use App\Enum\RolesEnum;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class PejabatPenggantiController extends Controller
{
    public function indexPejabatPengganti()
    {
        // Redirect home page for role
        $route = RouteLink::homePage();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengaturan', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Pejabat Pengganti', 'link' => route('pejabatPengganti.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengaturan | Pejabat Pengganti',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb
        ];

        return view('pengaturan.data-pejabat-pengganti', $data);
    }

    public function formPejabatPengganti(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengaturan', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Pejabat Pengganti', 'link' => route('pejabatPengganti.index'), 'page' => ''],
            ['title' => $formTitle . ' Pejabat Pengganti', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Pengaturan | ' . $formTitle . ' Pejabat Pengganti',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Pejabat Pengganti'
        ];

        return view('pengaturan.form-pejabat-pengganti', $data);
    }
}
