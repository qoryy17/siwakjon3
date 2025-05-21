<?php

namespace App\Http\Controllers\Manajemen;

use Carbon\Carbon;
use App\Helpers\RouteLink;
use Illuminate\Support\Str;
use App\Helpers\TimeSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\Manajemen\EdocRapatModel;
use App\Models\Manajemen\DetailRapatModel;
use App\Models\Pengaturan\SetKodeRapatModel;
use App\Models\Manajemen\ManajemenRapatModel;
use App\Models\Pengguna\PejabatPenggantiModel;
use App\Models\Manajemen\DokumentasiRapatModel;
use App\Models\Manajemen\KlasifikasiRapatModel;
use App\Models\Manajemen\PengawasanBidangModel;
use App\Http\Requests\Manajemen\SetRapatRequest;
use App\Models\Manajemen\KlasifikasiJabatanModel;
use App\Http\Requests\Manajemen\FormNotulaRequest;
use App\Http\Requests\Manajemen\FormManajemenRapat;
use App\Http\Requests\Manajemen\FormUndanganRapatRequest;

class RapatController extends Controller
{
    public function indexRapat()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->whereHas('klasifikasiRapat', function ($query) {
            $query->where('rapat', '!=', 'Pengawasan');
        })->orderBy('created_at', 'desc')->get();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat Dinas', 'link' => route('rapat.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'klasifikasiRapat' => KlasifikasiRapatModel::where('aktif', '=', 'Y')->where('rapat', '!=', 'Pengawasan')->orderBy('created_at', 'desc')->get(),
            'klasifikasiJabatan' => KlasifikasiJabatanModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'rapat' => $rapat
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

        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));
        $dokumentasi = DokumentasiRapatModel::with('detailRapat')->where('detail_rapat_id', '=', $rapat->detailRapat->id)->first();
        $edoc = EdocRapatModel::with('detailRapat')->where('detail_rapat_id', '=', $rapat->detailRapat->id)->first();

        $data = [
            'title' => 'Manajemen Rapat | Detail Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'rapat' => $rapat,
            'dokumentasi' => $dokumentasi,
            'edoc' => $edoc
        ];

        return view('rapat.detail-rapat', $data);
    }

    public function searchKlasifikasiRapat(Request $request)
    {
        $result = KlasifikasiRapatModel::find($request->id);
        if (!$result) {
            return response()->json(['error' => 'Klasifikasi Rapat tidak ditemukan !']);
        }
        return response()->json($result->rapat);
    }

    public function formUndangan(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $routeBack = route('rapat.index');
            $searchRapat = null;

            // Search klasifikasi rapat on database
            $klasifikasiRapat = KlasifikasiRapatModel::findOrFail($request->input('klasifikasiRapat'));

            // Jika rapat adalah Lainnya maka penomoran kode klasifikasi surat menjadi fleksibel
            if ($klasifikasiRapat->rapat == 'Lainnya') {
                $request->validate([
                    'klasifikasiSurat' => 'required|string',
                ], [
                    'klasifikasiSurat.required' => 'Kode Klasifikasi Surat wajib di isi !',
                    'klasifikasiSurat.string' => 'Kode Klasifikasi Surat harus berupa karakter valid !',
                ]);

                $kodeSurat = htmlspecialchars($request->input('klasifikasiSurat'));

            } else {
                // Get Set Kode Surat on database
                $searchKodeSurat = SetKodeRapatModel::first();
                if (!$searchKodeSurat) {
                    return redirect()->back()->with('error', 'Kode Surat belum di atur !');
                }

                $kodeSurat = $searchKodeSurat->kode_rapat_dinas;
            }

            // Search klasifikasi jabatan on database
            $klasifikasiJabatan = KlasifikasiJabatanModel::findOrFail($request->input('klasifikasiJabatan'));
            if (!$klasifikasiJabatan) {
                return redirect()->back()->with('error', 'Klasifikasi Jabatan tidak ditemukan !');
            }

            // Generate index nomor dokumen rapat
            $indexNumber = ManajemenRapatModel::orderBy('created_at', 'desc')->lockForUpdate()->first();
            if (!$indexNumber) {
                $counter = 0;
            } else {
                $counter = $indexNumber->nomor_indeks;
            }
            $indexIncrement = intval($counter) + 1;

            // Generate nomor dokumen rapat
            $nomorDokumen = $indexIncrement . '/' . $klasifikasiJabatan->kode_jabatan . '.' . 'W2-U4/' . $kodeSurat . '/' . TimeSession::convertMonthToRoman() . '/' . date('Y');

            // Set value klasifikasi for form
            $klasifikasi = ['rapat' => Crypt::encrypt($klasifikasiRapat->id), 'jabatan' => $klasifikasiJabatan->jabatan];

        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $routeBack = route('rapat.detail', ['id' => $request->id]);
            $searchRapat = ManajemenRapatModel::with('detailRapat')->findOrFail(Crypt::decrypt($request->id));

            // Search klasifikasi rapat on database
            $klasifikasiRapat = KlasifikasiRapatModel::findOrFail($searchRapat->klasifikasi_rapat_id);

            // Set default nomor dokumen from database
            $nomorDokumen = $searchRapat->nomor_dokumen;

            // Set value klasifikasi for form
            $klasifikasi = ['rapat' => Crypt::encrypt($klasifikasiRapat->id)];
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        // Checking klasifikasi rapat on database
        if (!$klasifikasiRapat) {
            return redirect()->back()->with('error', 'Klasifikasi Rapat tidak ditemukan !');
        }

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
            'formTitle' => $formTitle . ' Rapat ' . $klasifikasiRapat->rapat,
            'routeBack' => $routeBack,
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'pejabatPengganti' => PejabatPenggantiModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'pegawai' => PegawaiModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'rapat' => $searchRapat,
            'nomorDokumen' => $nomorDokumen,
            'klasifikasi' => $klasifikasi
        ];

        return view('rapat.form-undangan', $data);
    }

    public function saveRapat(FormManajemenRapat $request, FormUndanganRapatRequest $requestRapat): RedirectResponse
    {
        // Run validated
        $request->validated();
        $requestRapat->validated();

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;
        $saveDetailRapat = null;

        $uniqueKodeRapat = Str::uuid();

        // Denial backward meeting date
        $inputDate = Carbon::createFromFormat('m/d/Y', htmlspecialchars($request->input('tanggalRapat')))->startOfDay();
        $nowDate = Carbon::now()->startOfDay();
        if ($inputDate->lt($nowDate)) {
            return redirect()->back()->with('error', 'Waah kamu terdeteksi membuat rapat tanggal mundur. Tidak boleh ya !');
        }

        if ($paramIncoming == 'save') {
            // Get index number from nomor dokumen
            $indexNumber = explode('/', htmlspecialchars($request->input('nomorDokumen')));
            try {
                DB::beginTransaction();
                $formData = [
                    'kode_rapat' => $uniqueKodeRapat,
                    'nomor_indeks' => $indexNumber[0],
                    'nomor_dokumen' => htmlspecialchars($request->input('nomorDokumen')),
                    'klasifikasi_rapat_id' => Crypt::decrypt(htmlspecialchars($request->input('klasifikasiRapat'))),
                    'dibuat' => Auth::user()->id,
                    'pejabat_penandatangan' => htmlspecialchars($request->input('pejabatPenandatangan')),
                ];

                $pejabatPengganti = htmlspecialchars($request->input('pejabatPengganti'));
                if ($pejabatPengganti && $pejabatPengganti != 'Tanpa Pejabat Pengganti') {
                    $formData['pejabat_pengganti_id'] = $pejabatPengganti;
                }

                $save = ManajemenRapatModel::create($formData);

                // On save finished call result manajemen rapat on dabatase
                $manajemenRapat = ManajemenRapatModel::where('kode_rapat', '=', $uniqueKodeRapat)->first();
                $formDetailRapat = [
                    'manajemen_rapat_id' => $manajemenRapat->id,
                    'tanggal_rapat' => Carbon::createFromFormat('m/d/Y', htmlspecialchars($request->input('tanggalRapat')))->format('Y-m-d'),
                    'sifat' => htmlspecialchars($requestRapat->input('sifat')),
                    'lampiran' => htmlspecialchars($requestRapat->input('lampiran')),
                    'perihal' => htmlspecialchars($requestRapat->input('perihal')),
                    'acara' => nl2br(htmlspecialchars($requestRapat->input('acara'))),
                    'agenda' => nl2br($requestRapat->input('agenda')),
                    'jam_mulai' => htmlspecialchars($requestRapat->input('jamRapat')),
                    'tempat' => htmlspecialchars($requestRapat->input('tempat')),
                    'peserta' => htmlspecialchars($requestRapat->input('peserta')),
                    'keterangan' => $requestRapat->input('keterangan'),
                ];
                $saveDetailRapat = DetailRapatModel::create($formDetailRapat);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', $th);
            }
            $success = 'Dokumen Rapat berhasil di simpan !';
            $error = 'Dokumen Rapat gagal di simpan !';
            $activity = 'Menambahkan rapat perihal : ' . $formDetailRapat['perihal'];
        } elseif ($paramIncoming == 'update') {
            try {
                DB::beginTransaction();
                $formData = [
                    'pejabat_penandatangan' => htmlspecialchars($request->input('pejabatPenandatangan')),
                ];

                if (htmlspecialchars($request->input('pejabatPengganti')) && htmlspecialchars($request->input('pejabatPengganti')) != 'null') {
                    $formData['pejabat_pengganti_id'] = htmlspecialchars($request->input('pejabatPengganti'));
                }

                $search = ManajemenRapatModel::findOrFail(Crypt::decrypt($request->input('id')));
                $save = $search->update($formData);

                // After manajemen rapat saving on database update detail rapat
                $manajemenRapat = ManajemenRapatModel::where('kode_rapat', '=', $uniqueKodeRapat)->first();
                $formDetailRapat = [
                    'tanggal_rapat' => Carbon::createFromFormat('m/d/Y', htmlspecialchars($request->input('tanggalRapat')))->format('Y-m-d'),
                    'sifat' => htmlspecialchars($requestRapat->input('sifat')),
                    'lampiran' => htmlspecialchars($requestRapat->input('lampiran')),
                    'perihal' => htmlspecialchars($requestRapat->input('perihal')),
                    'acara' => nl2br(htmlspecialchars($requestRapat->input('acara'))),
                    'agenda' => nl2br($requestRapat->input('agenda')),
                    'jam_mulai' => htmlspecialchars($requestRapat->input('jamRapat')),
                    'tempat' => htmlspecialchars($requestRapat->input('tempat')),
                    'peserta' => htmlspecialchars($requestRapat->input('peserta')),
                    'keterangan' => $requestRapat->input('keterangan'),
                ];

                $searchDetailRapat = DetailRapatModel::where('manajemen_rapat_id', '=', $search->id)->first();
                $saveDetailRapat = $searchDetailRapat->update($formDetailRapat);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', $th);
            }

            $success = 'Dokumen Rapat berhasil di perbarui !';
            $error = 'Dokumen Rapat gagal di perbarui !';
            $activity = 'Memperbarui rapat perihal ' . $formDetailRapat['perihal'];
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        if (!$saveDetailRapat) {
            return redirect()->back()->with('error', $error);
        }

        // Saving logs activity
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->route('rapat.index')->with('success', $success);
    }

    public function deleteRapat(Request $request): RedirectResponse
    {
        // Checking data manajemen rapat on database
        $rapat = ManajemenRapatModel::findOrFail(Crypt::decrypt($request->id));
        if ($rapat) {
            $detailRapat = DetailRapatModel::where('manajemen_rapat_id', '=', $rapat->id)->first();
            if ($detailRapat) {
                $detailRapat->delete();
            }

            $dokumentasi = DokumentasiRapatModel::where('detail_rapat_id', '=', $detailRapat->id)->first();
            if ($dokumentasi) {
                // Delete file dokumentasi
                if (Storage::disk('public')->exists($dokumentasi->path_file_dokumentasi)) {
                    Storage::disk('public')->delete($dokumentasi->path_file_dokumentasi);
                }
                $dokumentasi->delete();
            }

            $edoc = EdocRapatModel::where('detail_rapat_id', '=', $detailRapat->id)->first();
            if ($edoc) {
                // Delete file edoc pdf
                if (Storage::disk('public')->exists($edoc->path_file_edoc)) {
                    Storage::disk('public')->delete($edoc->path_file_edoc);
                }
                $dokumentasi->delete();
            }

            // Saving logs activity
            $activity = 'Menghapus rapat perihal : ' . $rapat->detailRapat->perihal;
            \App\Services\LogsService::saveLogs($activity);

            // After all data delete, remove data rapat on manajemen rapat
            $rapat->delete();
            return redirect()->route('rapat.index')->with('success', 'Rapat berhasil di hapus !');
        }
        return redirect()->route('rapat.index')->with('error', 'Rapat gagal di hapus !');
    }

    public function formNotula(Request $request)
    {
        // Get data rapat
        $searchRapat = ManajemenRapatModel::with('detailRapat')->findOrFail(Crypt::decrypt($request->id));

        if ($searchRapat->detailRapat->notulen != null) {
            $formTitle = 'Edit';
        } else {
            $formTitle = 'Tambah';
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
            'routeBack' => route('rapat.detail', ['id' => $request->id]),
            'pegawai' => PegawaiModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'rapat' => $searchRapat
        ];

        return view('rapat.form-notula', $data);
    }

    public function saveNotula(FormNotulaRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'jam_selesai' => htmlspecialchars($request->input('jamSelesai')),
            'pembahasan' => nl2br(htmlspecialchars($request->input('pembahasan'))),
            'pimpinan_rapat' => nl2br(htmlspecialchars($request->input('pimpinanRapat'))),
            'moderator' => htmlspecialchars($request->input('moderator')),
            'notulen' => htmlspecialchars($request->input('notulen')),
            'catatan' => $request->input('catatan'),
            'kesimpulan' => $request->input('kesimpulan'),
            'disahkan' => htmlspecialchars($request->input('disahkan')),
        ];

        try {
            DB::beginTransaction();
            $search = ManajemenRapatModel::findOrFail(Crypt::decrypt($request->input('id')));
            $notula = DetailRapatModel::where('manajemen_rapat_id', '=', $search->id)->first();
            $save = $notula->update($formData);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th);
        }

        if (!$save) {
            return redirect()->back()->with('error', 'Notula gagal di simpan !');
        }

        // Saving logs activity
        $activity = 'Menyimpan notula rapat perihal : ' . $notula->perihal;
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->back()->with('success', 'Notula berhasil di simpan !');
    }

    public function formDokumentasi(Request $request)
    {
        // Get data rapat
        $searchRapat = ManajemenRapatModel::with('detailRapat')->findOrFail(Crypt::decrypt($request->id));
        $dokumentasi = DokumentasiRapatModel::with('detailRapat')->where('detail_rapat_id', '=', $searchRapat->detailRapat->id)->get();

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
            'formTitle' => 'Dokumentasi',
            'routeBack' => route('rapat.detail', ['id' => $request->id]),
            'rapat' => $searchRapat,
            'dokumentasi' => $dokumentasi
        ];

        return view('rapat.form-dokumentasi', $data);
    }

    public function saveDokumentasi(Request $request): RedirectResponse
    {
        $year = date('Y');
        $month = date('m');
        $directory = 'images/rapat/' . $year . '/' . $month . '/';
        // this output directory : /images/rapat/2024/12/

        // Run validate file
        $request->validate(
            ['file' => 'required|file|mimes:png,jpg|max:10240'],
            [
                'file.required' => 'File wajib di isi !',
                'file.file' => 'File harus berupa file valid !',
                'file.mimes' => 'File hanya boleh bertipe png/jpg',
                'file.max' => 'File maksimal berukuran 10MB',
            ]
        );

        // File foto upload process
        $fileFoto = $request->file('file');
        $fileHashname = $fileFoto->hashName();
        $uploadPath = $directory . $fileHashname;
        $fileUpload = $fileFoto->storeAs($directory, $fileHashname, 'public');

        // If file foto has failed to upload
        if (!$fileUpload) {
            return redirect()->back()->with('error', 'Unggah file gagal !')->withInput();
        }

        $dokumentasi = DetailRapatModel::where('manajemen_rapat_id', '=', Crypt::decrypt($request->input('id')))->first();

        $formData = [
            'detail_rapat_id' => $dokumentasi->id,
            'path_file_dokumentasi' => $uploadPath,
        ];

        $save = DokumentasiRapatModel::create($formData);

        if (!$save) {
            return redirect()->back()->with('error', 'Dokumentasi gagal di simpan !');
        }

        // Saving logs activity
        $activity = 'Menyimpan dokumentasi rapat perihal : ' . $dokumentasi->perihal;
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->route('rapat.form-dokumentasi', ['id' => $request->input('id')])->with('success', 'Dokumentasi berhasil di simpan !');
    }

    public function deleteDokumentasi(Request $request): RedirectResponse
    {
        $dokumentasi = DokumentasiRapatModel::with('detailRapat')->findOrFail(Crypt::decrypt($request->id));
        if ($dokumentasi) {
            // Delete old file pdf
            if (Storage::disk('public')->exists($dokumentasi->path_file_dokumentasi)) {
                Storage::disk('public')->delete($dokumentasi->path_file_dokumentasi);
            }
            // Saving logs activity
            $activity = 'Menghapus dokumentasi rapat perihal : ' . $dokumentasi->detailRapat->perihal;
            \App\Services\LogsService::saveLogs($activity);
            $dokumentasi->delete();
            return redirect()->back()->with('success', 'Dokumentasi berhasil di hapus !');
        }

        return redirect()->route('rapat.form-dokumentasi', ['id' => Crypt::encrypt($dokumentasi->detailRapat->manajemen_rapat_id)])->with('error', 'Dokumentasi gagal di hapus !');
    }

    public function saveEdoc(Request $request): RedirectResponse
    {
        $year = date('Y');
        $month = date('m');
        $directory = 'pdf/rapat/' . $year . '/' . $month . '/';
        // this output directory : /pdf/rapat/2024/12/
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

        $edocRapat = DetailRapatModel::where('manajemen_rapat_id', '=', Crypt::decrypt($request->input('id')))->first();

        $formData = [
            'detail_rapat_id' => $edocRapat->id,
            'path_file_edoc' => $uploadPath,
        ];

        $existEdoc = EdocRapatModel::where('detail_rapat_id', '=', $edocRapat->id)->first();
        if ($existEdoc) {
            // Delete old file pdf
            if (Storage::disk('public')->exists($existEdoc->path_file_edoc)) {
                Storage::disk('public')->delete($existEdoc->path_file_edoc);
            }
            $save = $existEdoc->update($formData);
            $activity = 'Memperbarui edoc file rapat :' . $edocRapat->perihal;
        } else {
            $save = EdocRapatModel::create($formData);
            $activity = 'Mengunggah edoc file rapat :' . $edocRapat->perihal;
        }

        if (!$save) {
            return redirect()->back()->with('error', 'File Edoc gagal di simpan !');
        }

        // Saving logs activity
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->route('rapat.detail', ['id' => $request->input('id')])->with('success', 'File Edoc berhasil di simpan !');
    }

    public function indexSetRapat()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengaturan', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Set Rapat Dinas ', 'link' => route('rapat.set-rapat'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengaturan | Set Rapat Dinas',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'klasifikasi' => KlasifikasiRapatModel::where('aktif', '=', 'Y')->orderBy('updated_at', 'desc')->get(),
            'rapat' => ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->orderBy('created_at', 'desc')->get()
        ];

        return view('pengaturan.set-rapat', $data);
    }

    public function saveSetRapat(SetRapatRequest $request): RedirectResponse
    {
        // Run validate
        $request->validated();
        $save = null;

        // Search rapat on manajemen rapat
        $searchRapat = ManajemenRapatModel::with('detailRapat')->findOrFail(Crypt::decrypt($request->input('rapat')));

        // Is rapat already on pengawasan bidang ?
        $searchRapatOnPengawasan = PengawasanBidangModel::where('detail_rapat_id', '=', $searchRapat->detailRapat->id)->first();
        if ($searchRapatOnPengawasan) {
            return redirect()->back()->with('error', 'Rapat pengawasan bidang ini tidak dapat di set, karena telah sampai tahap laporan pengawasan !');
        }
        // Search klasifikasi rapat on database
        $klasifikasiRapat = KlasifikasiRapatModel::findOrFail(Crypt::decrypt($request->input('klasifikasi')));

        if (htmlspecialchars($request->input('nomorRapat'))) {

            // Run additonal validate
            $request->validate(
                ['nomorRapat' => 'numeric|string'],
                [
                    'nomorRapat.numeric' => 'Nomor rapat harus berupa angka !',
                    'nomorRapat.string' => 'Nomor rapat harus berupa karakter valid !',
                ]
            );

            // Change old nomor dokumen to new nomor dokumen
            $explodeNomorDokumen = explode('/', $searchRapat->nomor_dokumen);
            $indexsNumber = htmlspecialchars($request->input('nomorRapat'));
            $implodeNomorDokumen = $indexsNumber . '/' . $explodeNomorDokumen[1] . '/' . $explodeNomorDokumen[2] . '/' . $explodeNomorDokumen[3] . '/' . $explodeNomorDokumen[4];

            $formData = [
                'nomor_indeks' => $indexsNumber,
                'nomor_dokumen' => $implodeNomorDokumen,
                'klasifikasi_rapat_id' => htmlspecialchars(Crypt::decrypt($request->input('klasifikasi'))),
            ];

            $activity = 'Mengubah klasifikasi rapat : ' . $searchRapat->detailRapat->perihal . ' menjadi Rapat ' . $klasifikasiRapat->rapat . ', dengan nomor dokumen lama ' . $searchRapat->nomor_dokumen . ' menjadi ' . $implodeNomorDokumen;
        } else {
            $formData = [
                'klasifikasi_rapat_id' => htmlspecialchars(Crypt::decrypt($request->input('klasifikasi'))),
            ];

            $activity = 'Mengubah klasifikasi rapat : ' . $searchRapat->detailRapat->perihal . ' menjadi Rapat ' . $klasifikasiRapat->rapat;
        }

        // Save change data on database
        $save = $searchRapat->update($formData);

        if (!$save) {
            return redirect()->back()->with('error', 'Set Rapat Dinas/Pengawasan gagal di simpan !');
        }

        // Saving logs activity
        \App\Services\LogsService::saveLogs($activity);

        return redirect()->back()->with('success', 'Set Rapat Dinas/Pengawasan berhasil di simpan !');
    }
}
