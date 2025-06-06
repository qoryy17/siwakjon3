<?php

namespace App\Http\Controllers\Penggguna;

use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna\JabatanModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\Pengaturan\JabatanRequest;

class JabatanController extends Controller
{
    public function indexJabatan()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengaturan', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Jabatan', 'link' => route('jabatan.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengaturan | Jabatan',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'jabatan' => JabatanModel::orderBy('updated_at', 'desc')->get()
        ];

        return view('pengaturan.data-jabatan', $data);
    }

    public function formJabatan(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchJabatan = null;
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchJabatan = JabatanModel::findOrFail(Crypt::decrypt($request->id));
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

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
            'formTitle' => $formTitle . ' Jabatan',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'jabatan' => $searchJabatan
        ];

        return view('pengaturan.form-jabatan', $data);
    }

    public function save(JabatanRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'jabatan' => htmlspecialchars($request->input('jabatan')),
            'kode_jabatan' => htmlspecialchars($request->input('kodeJabatan')),
            'aktif' => htmlspecialchars($request->input('aktif')),
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            $save = JabatanModel::create($formData);
            $success = 'Jabatan berhasil di simpan !';
            $error = 'Jabatan gagal di simpan !';
            $activity = 'Menambahkan jabatan : ' . $formData['jabatan'];
        } elseif ($paramIncoming == 'update') {
            $search = JabatanModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Jabatan berhasil di perbarui !';
            $error = 'Jabatan gagal di perbarui !';
            $activity = 'Memperbarui jabatan : ' . $formData['jabatan'];
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !')->withInput();
        }

        if (!$save) {
            return redirect()->back()->with('error', $error)->withInput();
        }

        // Saving logs activity
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->route('jabatan.index')->with('success', $success);
    }

    public function delete(Request $request): RedirectResponse
    {
        // Checking data jabatan on database
        $jabatan = JabatanModel::findOrFail(Crypt::decrypt($request->id));
        if ($jabatan) {
            // Saving logs activity
            $activity = 'Menghapus jabatan : ' . $jabatan->jabatan;
            \App\Services\LogsService::saveLogs($activity);
            $jabatan->delete();
            return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil di hapus !');
        }
        return redirect()->route('jabatan.index')->with('error', 'Jabatan gagal di hapus !');
    }
}
