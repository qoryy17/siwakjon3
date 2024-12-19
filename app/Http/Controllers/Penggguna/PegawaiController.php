<?php

namespace App\Http\Controllers\Penggguna;

use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna\JabatanModel;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Pengguna\PegawaiRequest;

class PegawaiController extends Controller
{

    public function indexPegawai()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengguna', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Pegawai', 'link' => route('pengguna.pegawai'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengguna | Pegawai',
            'routeHome' => route('home.superadmin'),
            'breadcumbs' => $breadcumb,
            'pegawai' => PegawaiModel::with('jabatan')->orderBy('created_at', 'desc')->get(),
        ];

        return view('pengguna.data-pegawai', $data);
    }

    public function formPegawai(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchPegawai = null;
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchPegawai = PegawaiModel::findOrFail(Crypt::decrypt($request->id));
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengguna', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Pegawai', 'link' => route('pengguna.pegawai'), 'page' => ''],
            ['title' => $formTitle . ' Pegawai', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Pengguna | ' . $formTitle . ' Pegawai',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Pegawai',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'pegawai' => $searchPegawai,
            'jabatan' => JabatanModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get()
        ];

        return view('pengguna.form-pegawai', $data);
    }

    public function savePegawai(PegawaiRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'nip' => htmlspecialchars($request->input('nip')),
            'nama' => htmlspecialchars($request->input('nama')),
            'jabatan_id' => htmlspecialchars($request->input('jabatan')),
            'aktif' => htmlspecialchars($request->input('aktif')),
            'keterangan' => nl2br(htmlspecialchars($request->input('keterangan'))),
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        $directory = 'images/pegawai/';

        if ($paramIncoming == 'save') {
            if ($request->file('foto')) {
                // Foto upload process
                $fileFoto = $request->file('foto');
                $fileHashname = $fileFoto->hashName();
                $uploadPath = $directory . $fileHashname;
                $fileUpload = $fileFoto->storeAs($directory, $fileHashname, 'public');

                // If Foto has failed to upload
                if (!$fileUpload) {
                    return redirect()->back()->with('error', 'Unggah Foto gagal !')->withInput();
                }

                $formData['foto'] = $uploadPath;
            }

            $save = PegawaiModel::create($formData);
            $success = 'Pegawai berhasil di simpan !';
            $error = 'Pegawai gagal di simpan !';
        } elseif ($paramIncoming == 'update') {
            $search = PegawaiModel::findOrFail(Crypt::decrypt($request->input('id')));

            if ($request->file('foto')) {
                // Delete old foto
                if (Storage::disk('public')->exists($directory . $search->foto)) {
                    Storage::disk('public')->delete($directory . $search->foto);
                }
                // Foto upload process
                $fileFoto = $request->file('foto');
                $fileHashname = $fileFoto->hashName();
                $uploadPath = $directory . $fileHashname;
                $fileUpload = $fileFoto->storeAs($directory, $fileHashname, 'public');

                // If Foto has failed to upload
                if (!$fileUpload) {
                    return redirect()->back()->with('error', 'Unggah Foto gagal !')->withInput();
                }

                $formData['foto'] = $uploadPath;
            }
            $save = $search->update($formData);
            $success = 'Pegawai berhasil di perbarui !';
            $error = 'Pegawai gagal di perbarui !';
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->route('pengguna.pegawai')->with('success', $success);
    }

    public function deletePegawai(Request $request): RedirectResponse
    {
        // Checking data pegawai on database
        $pegawai = PegawaiModel::findOrFail(Crypt::decrypt($request->id));
        if ($pegawai) {
            // Delete old foto
            if (Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            $pegawai->delete();
            return redirect()->route('pengguna.pegawai')->with('success', 'Pegawai berhasil di hapus !');
        }
        return redirect()->route('pengguna.pegawai')->with('error', 'Pegawai gagal di hapus !');
    }
}
