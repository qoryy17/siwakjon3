<?php

namespace App\Http\Controllers\Pengaturan;

use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengaturan\LogsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\Pengaturan\UnitKerjaModel;
use App\Http\Requests\Pengaturan\UnitKerjaRequest;

class UnitKerjaController extends Controller
{
    public function indexUnitKerja()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengaturan', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Unit Kerja', 'link' => route('unitKerja.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengaturan | Unit Kerja',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'unitKerja' => UnitKerjaModel::orderBy('updated_at', 'desc')->get()
        ];

        return view('pengaturan.data-unit-kerja', $data);
    }

    public function formUnitKerja(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchUnitKerja = null;
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchUnitKerja = UnitKerjaModel::findOrFail(Crypt::decrypt($request->id));
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

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
            'formTitle' => $formTitle . ' Unit Kerja',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'unitKerja' => $searchUnitKerja
        ];

        return view('pengaturan.form-unit-kerja', $data);
    }
    public function save(UnitKerjaRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'unit_kerja' => htmlspecialchars($request->input('unitKerja')),
            'aktif' => htmlspecialchars($request->input('aktif')),
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            $save = UnitKerjaModel::create($formData);
            $success = 'Unit Kerja berhasil di simpan !';
            $error = 'Unit Kerja gagal di simpan !';
            $activity = Auth::user()->name . ' Menambahkan unit kerja ' . $formData['unit_kerja'] . ', timestamp ' . now();
        } elseif ($paramIncoming == 'update') {
            $search = UnitKerjaModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Unit Kerja berhasil di perbarui !';
            $error = 'Unit Kerja gagal di perbarui !';
            $activity = Auth::user()->name . ' Memperbarui unit kerja dengan id ' . $request->input('id') . ', timestamp ' . now();
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        // Saving logs activity
        LogsModel::create(
            [
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'activity' => $activity
            ]
        );

        return redirect()->route('unitKerja.index')->with('success', $success);
    }

    public function delete(Request $request): RedirectResponse
    {
        // Checking data unit kerja on database
        $unitKerja = UnitKerjaModel::findOrFail(Crypt::decrypt($request->id));
        if ($unitKerja) {
            // Saving logs activity
            LogsModel::create(
                [
                    'user_id' => Auth::user()->id,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'activity' => Auth::user()->name . ' Menghapus unit kerja ' . $unitKerja->unit_kerja . ', timestamp ' . now()
                ]
            );
            $unitKerja->delete();
            return redirect()->route('unitKerja.index')->with('success', 'Unit Kerja berhasil di hapus !');
        }
        return redirect()->route('unitKerja.index')->with('error', 'Unit Kerja gagal di hapus !');
    }
}
