<?php

namespace App\Http\Controllers\Arsip;

use Carbon\Carbon;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\Arsip\ArsipSuratKeputusanModel;
use App\Http\Requests\Arsip\SuratKeputusanRequest;

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

    public function save(SuratKeputusanRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'nomor' => htmlspecialchars($request->input('nomor')),
            'judul' => htmlspecialchars($request->input('judul')),
            'tanggal_terbit' => Carbon::createFromFormat('m/d/Y', htmlentities($request->input('tanggalTerbit')))->format('Y-m-d'),
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;
        $month = date('m');
        $year = date('Y');
        $directory = 'pdf/arsip-sk/' . $month . '/' . $year . '/';
        // this output directory : /pdf/arsip-sk/1/2024/

        if ($paramIncoming == 'save') {

            // Run validate file
            $request->validate(
                ['file' => 'required|file|mimes:pdf|max:10240'],
                [
                    'file.required' => 'File wajib di isi !',
                    'file.file' => 'File harus berupa file valid !',
                    'file.mimes' => 'File hanya boleh bertipe pdf',
                    'file.max' => 'File maksimal berukuran 10MB',
                ]
            );

            // File pdf upload process
            $filePDF = $request->file('file');
            $fileHashname = $filePDF->hashName();
            $uploadPath = $directory . $fileHashname;
            $fileUpload = $filePDF->storeAs($directory, $fileHashname, 'public');

            // If file pdf has failed to upload
            if (!$fileUpload) {
                return redirect()->back()->with('error', 'Unggah file gagal !')->withInput();
            }

            $formData['path_file_sk'] = $uploadPath;
            $formData['status'] = htmlspecialchars($request->input('status'));
            $formData['diunggah'] = Auth::user()->id;

            $save = ArsipSuratKeputusanModel::create($formData);
            $success = 'Arsip Surat Keputusan berhasil di simpan !';
            $error = 'Arsip Surat Keputusan gagal di simpan !';
        } elseif ($paramIncoming == 'update') {
            $search = ArsipSuratKeputusanModel::findOrFail(Crypt::decrypt($request->input('id')));
            if ($request->file('file')) {
                // Run validate file
                $request->validate(
                    ['file' => 'file|mimes:pdf|max:10240'],
                    [
                        'file.file' => 'File harus berupa file valid !',
                        'file.mimes' => 'File hanya boleh bertipe pdf',
                        'file.max' => 'File maksimal berukuran 10MB',
                    ]
                );

                // Delete old file pdf
                if (Storage::disk('public')->exists($directory . $search->path_file_sk)) {
                    Storage::disk('public')->delete($directory . $search->path_file_sk);
                }

                // File pdf upload process
                $filePDF = $request->file('file');
                $fileHashname = $filePDF->hashName();
                $uploadPath = $directory . $fileHashname;
                $fileUpload = $filePDF->storeAs($directory, $fileHashname, 'public');

                // If file pdf has failed to upload
                if (!$fileUpload) {
                    return redirect()->back()->with('error', 'Unggah file gagal !')->withInput();
                }

                $formData['path_file_sk'] = $uploadPath;
            }
            $formData['status'] = htmlspecialchars($request->input('status'));
            $formData['diunggah'] = Auth::user()->id;

            $save = $search->update($formData);
            $success = 'Arsip Surat Keputusan berhasil di perbarui !';
            $error = 'Arsip Surat Keputusan gagal di perbarui !';
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->route('arsip.surat-keputusan')->with('success', $success);
    }

    public function delete(Request $request): RedirectResponse
    {
        // Checking data surat keputusan on database
        $suratKeputusan = ArsipSuratKeputusanModel::findOrFail(Crypt::decrypt($request->id));
        if ($suratKeputusan) {
            // Delete old file pdf
            if (Storage::disk('public')->exists($suratKeputusan->path_file_sk)) {
                Storage::disk('public')->delete($suratKeputusan->path_file_sk);
            }
            $suratKeputusan->delete();
            return redirect()->route('arsip.surat-keputusan')->with('success', 'Arsip Surat Keputusan berhasil di hapus !');
        }
        return redirect()->route('arsip.surat-keputusan')->with('error', 'Arsip Surat Keputusan gagal di hapus !');
    }
}
