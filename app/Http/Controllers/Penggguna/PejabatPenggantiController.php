<?php

namespace App\Http\Controllers\Penggguna;

use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\Pengguna\PejabatPenggantiModel;
use App\Http\Requests\Pengaturan\PejabatPenggantiRequest;

class PejabatPenggantiController extends Controller
{
    public function indexPejabatPengganti()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengaturan', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Pejabat Pengganti', 'link' => route('pejabatPengganti.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengaturan | Pejabat Pengganti',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'pejabatPengganti' => PejabatPenggantiModel::orderBy('updated_at', 'desc')->get()
        ];

        return view('pengaturan.data-pejabat-pengganti', $data);
    }

    public function formPejabatPengganti(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchPejabatPengganti = null;
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchPejabatPengganti = PejabatPenggantiModel::findOrFail(Crypt::decrypt($request->id));
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

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
            'formTitle' => $formTitle . ' Pejabat Pengganti',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'pejabatPengganti' => $searchPejabatPengganti
        ];

        return view('pengaturan.form-pejabat-pengganti', $data);
    }

    public function save(PejabatPenggantiRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'pejabat' => htmlspecialchars($request->input('pejabatPengganti')),
            'aktif' => htmlspecialchars($request->input('aktif')),
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            $save = PejabatPenggantiModel::create($formData);
            $success = 'Pejabat Pengganti berhasil di simpan !';
            $error = 'Pejabat Pengganti gagal di simpan !';
            $activity = 'Menambahkan pejabat pengganti : ' . $formData['pejabat'];
        } elseif ($paramIncoming == 'update') {
            $search = PejabatPenggantiModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Pejabat Pengganti berhasil di perbarui !';
            $error = 'Pejabat Pengganti gagal di perbarui !';
            $activity = 'Memperbarui pejabat pengganti : ' . $formData['pejabat'];
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !')->withInput();
        }

        if (!$save) {
            return redirect()->back()->with('error', $error)->withInput();
        }

        // Saving logs activity
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->route('pejabatPengganti.index')->with('success', $success);
    }

    public function delete(Request $request): RedirectResponse
    {
        // Checking data pejabat pengganti on database
        $pejabatPengganti = PejabatPenggantiModel::findOrFail(Crypt::decrypt($request->id));
        if ($pejabatPengganti) {
            // Saving logs activity
            $activity = 'Menghapus pejabat pengganti : ' . $pejabatPengganti->pejabat;
            \App\Services\LogsService::saveLogs($activity);
            $pejabatPengganti->delete();
            return redirect()->route('pejabatPengganti.index')->with('success', 'Pejabat Pengganti berhasil di hapus !');
        }
        return redirect()->route('pejabatPengganti.index')->with('error', 'Pejabat Pengganti gagal di hapus !');
    }
}
