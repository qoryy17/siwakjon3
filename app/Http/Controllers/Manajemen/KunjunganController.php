<?php

namespace App\Http\Controllers\Manajemen;

use Carbon\Carbon;
use App\Helpers\RouteLink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\Hakim\HakimPengawasModel;
use App\Models\Pengaturan\UnitKerjaModel;
use App\Models\Manajemen\DetailKunjunganModel;
use App\Models\Manajemen\KunjunganPengawasanModel;
use App\Http\Requests\Manajemen\FormKunjunganRequest;
use App\Http\Requests\Manajemen\FormDetailKunjunganRequest;

class KunjunganController extends Controller
{
    public function indexKunjungan()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $kunjungan = KunjunganPengawasanModel::with('unitKerja')->with('detailKunjungan')->orderBy('created_at', 'desc')->get();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Kunjungan Pengawasan', 'link' => route('kunjungan.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengawasan Bidang | Kunjungan Pengawasan',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'kunjungan' => $kunjungan
        ];

        return view('pengawasan.data-kunjungan-pengawasan', $data);
    }

    public function formKunjungan(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchKunjungan = null;
            $kodeKunjungan = Str::uuid();
            $routeBack = route('kunjungan.index');
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchKunjungan = KunjunganPengawasanModel::findOrFail(Crypt::decrypt($request->id));
            $kodeKunjungan = $searchKunjungan->kode_kunjungan;
            $routeBack = route('kunjungan.detail', ['id' => $request->id]);
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Kunjungan Pengawasan', 'link' => route('kunjungan.index'), 'page' => ''],
            ['title' => $formTitle . ' Kunjungan Pengawasan', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengawasan Bidang | ' . $formTitle . ' Kunjungan Pengawasan',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Kunjungan Pengawasan',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'kunjungan' => $searchKunjungan,
            'unitKerja' => UnitKerjaModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'kodeKunjungan' => $kodeKunjungan,
            'routeBack' => $routeBack
        ];

        return view('pengawasan.form-kunjungan', $data);
    }

    public function detailKunjungan(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $hakim = HakimPengawasModel::with('unitKerja')->with('pegawai')->whereHas('pegawai', function ($query) {
            $query->orderBy('nama', 'asc');
        })->get();

        $kunjungan = KunjunganPengawasanModel::findOrFail(Crypt::decrypt($request->id));
        $detailKunjungan = DetailKunjunganModel::with('hakimPengawas')->where('kunjungan_pengawasan_id', '=', $kunjungan->id);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Kunjungan Pengawasan', 'link' => route('kunjungan.index'), 'page' => ''],
            ['title' => 'Detail', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengawasan Bidang | Detail Kunjungan Pengawasan',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'hakim' => $hakim,
            'kunjungan' => $kunjungan,
            'detailKunjungan' => $detailKunjungan
        ];

        return view('pengawasan.detail-kunjungan', $data);
    }

    public function saveKunjungan(FormKunjunganRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        $formData = [
            'kode_kunjungan' => htmlspecialchars($request->input('kodeKunjungan')),
            'unit_kerja_id' => htmlspecialchars($request->input('unitKerja')),
        ];

        $unitKerja = UnitKerjaModel::findOrFail($formData['unit_kerja_id']);

        if ($paramIncoming == 'save') {
            $formData['dibuat'] = Auth::user()->id;
            $save = KunjunganPengawasanModel::create($formData);
            $activity = 'Menambahkan kunjungan unit kerja : ' . $unitKerja->unit_kerja;
            $success = 'Kunjungan berhasil di simpan !';
            $error = 'Kunjungan gagal di simpan !';
            $routeBack = redirect()->route('kunjungan.index')->with('success', $success);
        } elseif ($paramIncoming == 'update') {
            $search = KunjunganPengawasanModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Kunjungan berhasil di perbarui !';
            $error = 'Kunjungan gagal di perbarui !';
            $activity = 'Memperbarui kunjungan unit kerja : ' . $unitKerja->unit_kerja;
            $routeBack = redirect()->route('kunjungan.detail', ['id' => $request->input('id')])->with('success', $success);
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !')->withInput();
        }

        // Saving logs activity
        \App\Services\LogsService::saveLogs($activity);

        if (!$save) {
            return redirect()->back()->with('error', $error)->withInput();
        }

        return $routeBack;
    }

    public function deleteKunjungan(Request $request): RedirectResponse
    {
        $kunjungan = KunjunganPengawasanModel::findOrFail(Crypt::decrypt($request->id));
        if ($kunjungan) {

            if ($kunjungan->path_file_edoc != null) {
                // Delete file edoc pdf
                if (Storage::disk('public')->exists($kunjungan->path_file_edoc)) {
                    Storage::disk('public')->delete($kunjungan->path_file_edoc);
                }
            }

            $detailKunjungan = DetailKunjunganModel::where('kunjungan_pengawasan_id', '=', $kunjungan->id)->first();
            if ($detailKunjungan) {
                $detailKunjungan->delete();
            }
            // Saving logs activity
            $activity = 'Menghapus kunjungan kode kunjungan : ' . $kunjungan->kode_kunjungan;
            \App\Services\LogsService::saveLogs($activity);

            $kunjungan->delete();
            return redirect()->route('kunjungan.index')->with('success', 'Kunjungan berhasil di hapus !');
        }

        return redirect()->route('kunjungan.index')->with('error', 'Kunjungan gagal di hapus !');
    }

    public function saveAgenda(FormDetailKunjunganRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        $formData = [
            'kunjungan_pengawasan_id' => htmlspecialchars(Crypt::decrypt($request->input('idKunjungan'))),
            'tanggal' => Carbon::createFromFormat('m/d/Y', htmlspecialchars($request->input('tanggal')))->format('Y-m-d'),
            'waktu' => htmlspecialchars($request->input('waktu')),
            'agenda' => htmlspecialchars($request->input('agenda')),
            'pembahasan' => $request->input('pembahasan'),
            'hakim_pengawas_id' => htmlspecialchars($request->input('hakim')),
        ];

        if ($paramIncoming == 'save') {
            $save = DetailKunjunganModel::create($formData);
            $activity = 'Menambahkan agenda kunjungan  ' . $formData['agenda'];
            $success = 'Agenda Kunjungan berhasil di simpan !';
            $error = 'Agenda Kunjungan gagal di simpan !';
        } elseif ($paramIncoming == 'update') {
            $search = DetailKunjunganModel::findOrFail(Crypt::decrypt($request->input('idAgenda')));
            $save = $search->update($formData);
            $success = 'Agenda Kunjungan berhasil di perbarui !';
            $error = 'Agenda Kunjungan gagal di perbarui !';
            $activity = 'Memperbarui agenda kunjungan : ' . $formData['agenda'];
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !')->withInput();
        }

        // Saving logs activity
        \App\Services\LogsService::saveLogs($activity);

        if (!$save) {
            return redirect()->back()->with('error', $error)->withInput();
        }

        return redirect()->route('kunjungan.detail', ['id' => $request->input('idKunjungan')])->with('success', $success);
    }

    public function deleteAgenda(Request $request): RedirectResponse
    {
        $detailKunjungan = DetailKunjunganModel::findOrFail(Crypt::decrypt($request->id));
        if ($detailKunjungan) {
            // Saving logs activity
            $activity = 'Menghapus agenda kunjungan : ' . $detailKunjungan->agenda;
            \App\Services\LogsService::saveLogs($activity);
            $detailKunjungan->delete();
            return redirect()->route('kunjungan.detail', ['id' => Crypt::encrypt($detailKunjungan->kunjungan_pengawasan_id)])->with('success', 'Agenda Kunjungan berhasil di hapus !');
        }

        return redirect()->route('kunjungan.detail', ['id' => Crypt::encrypt($detailKunjungan->kunjungan_pengawasan_id)])->with('error', 'Agenda Kunjungan gagal di hapus !');
    }

    public function saveEdoc(Request $request): RedirectResponse
    {
        $year = date('Y');
        $month = date('m');
        $directory = 'pdf/kunjungan/' . $year . '/' . $month . '/';
        // this output directory : /pdf/kunjungan/2024/12/
        $save = null;

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

        $existEdoc = KunjunganPengawasanModel::with('unitKerja')->findOrFail(Crypt::decrypt($request->input('id')));

        $formData = [
            'path_file_edoc' => $uploadPath,
            'waktu_unggah' => now(),
        ];

        if ($existEdoc->path_file_edoc != null) {
            // Delete old file pdf
            if (!empty($existEdoc->path_file_edoc) && Storage::disk('public')->exists($existEdoc->path_file_edoc)) {
                Storage::disk('public')->delete($existEdoc->path_file_edoc);
            }
            $activity = 'Memperbarui edoc kunjungan pengawasan ' . $existEdoc->unitKerja->unit_kerja;
        } else {
            $activity = 'Menambahkan edoc kunjungan pengawasan ' . $existEdoc->unitKerja->unit_kerja;
        }

        $save = $existEdoc->update($formData);

        if (!$save) {
            return redirect()->back()->with('error', 'File Edoc gagal di simpan !')->withInput();
        }

        // Saving logs activity
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->route('kunjungan.detail', ['id' => $request->input('id')])->with('success', 'File Edoc berhasil di simpan !');
    }
}
