<?php

namespace App\Http\Controllers\Penggguna;

use App\Enum\RolesEnum;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class JabatanController extends Controller
{
    public function indexJabatan()
    {
        // Redirect home page for role
        $route = RouteLink::homePage();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengaturan', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Jabatan', 'link' => route('jabatan.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengaturan | Jabatan',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb
        ];

        return view('pengaturan.data-jabatan', $data);
    }

    public function formJabatan(Request $request)
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
            ['title' => 'Jabatan', 'link' => route('jabatan.index'), 'page' => ''],
            ['title' => $formTitle . ' Jabatan', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Pengaturan | ' . $formTitle . ' Jabatan',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Jabatan'
        ];

        return view('pengaturan.form-jabatan', $data);
    }
}
