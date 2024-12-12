<?php

namespace App\Http\Controllers\Pengaturan;

use App\Enum\RolesEnum;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class UnitKerjaController extends Controller
{
    public function indexUnitKerja()
    {
        // Redirect home page for role
        $route = RouteLink::homePage();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengaturan', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Unit Kerja', 'link' => route('unitKerja.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengaturan | Unit Kerja',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb
        ];

        return view('pengaturan.data-unit-kerja', $data);
    }

    public function formUnitKerja(Request $request)
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
            ['title' => 'Unit Kerja', 'link' => route('unitKerja.index'), 'page' => ''],
            ['title' => $formTitle . ' Unit Kerja', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Pengaturan | ' . $formTitle . ' Unit Kerja',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Unit Kerja'
        ];

        return view('pengaturan.form-unit-kerja', $data);
    }
}
