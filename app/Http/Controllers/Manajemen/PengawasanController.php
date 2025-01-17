<?php

namespace App\Http\Controllers\Manajemen;

use Carbon\Carbon;
use App\Helpers\RouteLink;
use Illuminate\Support\Str;
use App\Helpers\TimeSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pengaturan\LogsModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\Hakim\HakimPengawasModel;
use App\Models\Manajemen\EdocWasbidModel;
use App\Models\Pengaturan\UnitKerjaModel;
use App\Models\Manajemen\DetailRapatModel;
use App\Models\Manajemen\TemuanWasbidModel;
use App\Models\Pengaturan\SetKodeRapatModel;
use App\Models\Manajemen\ManajemenRapatModel;
use App\Models\Manajemen\DokumentasiRapatModel;
use App\Models\Manajemen\KlasifikasiRapatModel;
use App\Models\Manajemen\PengawasanBidangModel;
use App\Http\Requests\Manajemen\FormNotulaRequest;
use App\Http\Requests\Manajemen\FormManajemenRapat;
use App\Http\Requests\Manajemen\TemuanWasbidRequest;
use App\Http\Requests\Manajemen\FormUndanganRapatRequest;
use App\Models\Pengaturan\AplikasiModel;

class PengawasanController extends Controller
{
    public function indexPengawasan()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->whereHas('klasifikasiRapat', function ($query) {
            $query->where('rapat', 'Pengawasan');
        })->orderBy('created_at', 'desc')->get();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat Pengawasan', 'link' => route('pengawasan.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengawasan Bidang',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'rapat' => $rapat
        ];

        return view('pengawasan.data-rapat-pengawasan', $data);
    }

    public function detailPengawasan(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat Pengawasan', 'link' => route('pengawasan.index'), 'page' => ''],
            ['title' => 'Detail', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));
        $dokumentasi = DokumentasiRapatModel::with('detailRapat')->where('detail_rapat_id', '=', $rapat->detailRapat->id)->first();
        $pengawasan = PengawasanBidangModel::with('temuanWasbid')->where('detail_rapat_id', '=', $rapat->detailRapat->id)->first();
        if ($pengawasan) {
            $edoc = EdocWasbidModel::with('pengawasanBidang')->where('pengawasan_bidang_id', '=', $pengawasan->id)->first();
            $kodePengawasan = $pengawasan->kode_pengawasan;
        } else {
            $edoc = null;
            $kodePengawasan = Str::uuid();
        }

        $data = [
            'title' => 'Manajemen Rapat | Detail Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'rapat' => $rapat,
            'pengawasan' => $pengawasan,
            'dokumentasi' => $dokumentasi,
            'edoc' => $edoc,
            'kodePengawasan' => $kodePengawasan
        ];

        return view('pengawasan.detail-pengawasan', $data);
    }

    public function formUndangan(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $routeBack = route('pengawasan.index');
            $searchRapat = null;

            // Search klasifikasi rapat on database
            $klasifikasiRapat = KlasifikasiRapatModel::where('rapat', '=', 'Pengawasan')->first();

            // Generate index nomor dokumen rapat
            $indexNumber = ManajemenRapatModel::orderBy('created_at', 'desc')->lockForUpdate()->first();
            if (!$indexNumber) {
                $counter = 0;
            } else {
                $counter = $indexNumber->nomor_indeks;
            }
            $indexIncrement = intval($counter) + 1;

            // Get Set Kode Surat on database
            $searchKodeSurat = SetKodeRapatModel::first();
            if (!$searchKodeSurat) {
                return redirect()->back()->with('error', 'Kode Surat belum di set !');
            }

            // Generate nomor dokumen rapat
            $nomorDokumen = $indexIncrement . '/' . 'UND.W2-U4/' . $searchKodeSurat->kode_pengawasan . '/' . TimeSession::convertMonthToRoman() . '/' . date('Y');

            // Set value klasifikasi for form
            $klasifikasi = ['rapat' => Crypt::encrypt($klasifikasiRapat->id)];

        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $routeBack = route('pengawasan.detail', ['id' => $request->id]);
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
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat', 'link' => route('rapat.index'), 'page' => ''],
            ['title' => $formTitle . ' Rapat', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $hakim = PegawaiModel::with('jabatan')->whereHas('jabatan', function ($query) {
            $query->where('jabatan', 'Hakim');
        })->where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get();

        $data = [
            'title' => 'Pengawasan Bidang | ' . $formTitle . ' Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Rapat ' . $klasifikasiRapat->rapat,
            'routeBack' => $routeBack,
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'hakim' => $hakim,
            'rapat' => $searchRapat,
            'nomorDokumen' => $nomorDokumen,
            'klasifikasi' => $klasifikasi
        ];

        return view('pengawasan.form-undangan', $data);

    }

    public function savePengawasan(FormManajemenRapat $request, FormUndanganRapatRequest $requestRapat): RedirectResponse
    {
        // Run validated
        $request->validated();
        $requestRapat->validated();

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;
        $saveDetailRapat = null;

        $uniqueKodeRapat = Str::uuid();

        // Denial backward meeting date
        $inputDate = Carbon::createFromFormat('m/d/Y', htmlspecialchars($request->input('tanggalRapat')))->format('d-m-Y');
        $nowDate = date('d-m-Y');
        if ($inputDate < $nowDate) {
            return redirect()->back()->with('error', 'Tidak dapat membuat rapat tanggal mundur !');
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
                    'agenda' => nl2br(htmlspecialchars($requestRapat->input('agenda'))),
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
            $activity = Auth::user()->name . ' Menambahkan dokumen pengawasan ' . $formDetailRapat['perihal'] . ', timestamp ' . now();
        } elseif ($paramIncoming == 'update') {
            try {
                DB::beginTransaction();
                $formData = [
                    'pejabat_penandatangan' => htmlspecialchars($request->input('pejabatPenandatangan')),
                ];

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
                    'agenda' => nl2br(htmlspecialchars($requestRapat->input('agenda'))),
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
            $activity = Auth::user()->name . 'Memperbarui dokumen pengawasan dengan id ' . $request->input('id') . ', timestamp ' . now();
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
        LogsModel::create(
            [
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'activity' => $activity
            ]
        );

        return redirect()->route('pengawasan.index')->with('success', $success);
    }

    public function deletePengawasan(Request $request): RedirectResponse
    {
        // Checking data manajemen rapat on database
        $rapat = ManajemenRapatModel::findOrFail(Crypt::decrypt($request->id));
        if ($rapat) {
            // Delete detail rapat
            $detailRapat = DetailRapatModel::where('manajemen_rapat_id', '=', $rapat->id)->first();
            if ($detailRapat) {
                $detailRapat->delete();
            }

            // Delete dokumentasi
            $dokumentasi = DokumentasiRapatModel::where('detail_rapat_id', '=', $detailRapat->id)->first();
            if ($dokumentasi) {
                // Delete file dokumentasi
                if (Storage::disk('public')->exists($dokumentasi->path_file_dokumentasi)) {
                    Storage::disk('public')->delete($dokumentasi->path_file_dokumentasi);
                }
                $dokumentasi->delete();
            }

            // Delete pengawasan bidang
            $pengawasan = PengawasanBidangModel::where('detail_rapat_id', '=', $detailRapat->id)->first();
            if ($pengawasan) {
                $pengawasan->delete();
            }

            // Delete temuan pengawasan bidang
            $temuan = TemuanWasbidModel::where('pengawasan_bidang_id', '=', $pengawasan->id)->first();
            if ($temuan) {
                $temuan->delete();
            }

            // Delete file edoc tlhp
            $edoc = EdocWasbidModel::where('pengawasan_bidang_id', '=', $pengawasan->id)->first();
            if ($edoc) {
                // Delete file edoc pdf
                if (Storage::disk('public')->exists($edoc->path_file_tlhp)) {
                    Storage::disk('public')->delete($edoc->path_file_tlhp);
                }
                $edoc->delete();
            }

            // Saving logs activity
            LogsModel::create(
                [
                    'user_id' => Auth::user()->id,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'activity' => Auth::user()->name . ' Menghapus dokumen pengawasan ' . $detailRapat->perihal . ', timestamp ' . now()
                ]
            );

            // After all data delete, remove data rapat on manajemen rapat
            $rapat->delete();
            return redirect()->route('pengawasan.index')->with('success', 'Rapat berhasil di hapus !');
        }
        return redirect()->route('pengawasan.index')->with('error', 'Rapat gagal di hapus !');
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
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat Pengawasan', 'link' => route('pengawasan.index'), 'page' => ''],
            ['title' => $formTitle . ' Notula', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengawasan Bidang | ' . $formTitle . ' Notula',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Notula ',
            'routeBack' => route('pengawasan.detail', ['id' => $request->id]),
            'pegawai' => PegawaiModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'rapat' => $searchRapat
        ];

        return view('pengawasan.form-notula', $data);
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
            'catatan' => nl2br(htmlspecialchars($request->input('catatan'))),
            'kesimpulan' => nl2br(htmlspecialchars($request->input('kesimpulan'))),
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
        LogsModel::create(
            [
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'activity' => Auth::user()->name . ' Menyimpan notula pengawasan ' . $notula->perihal . ', timestamp' . now()
            ]
        );

        return redirect()->route('pengawasan.detail', ['id' => $request->input('id')])->with('success', 'Notula berhasil di simpan !');
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
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat Pengawasan', 'link' => route('pengawasan.index'), 'page' => ''],
            ['title' => 'Dokumentasi', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengawasan Bidang | ' . 'Dokumentasi',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => 'Dokumentasi',
            'routeBack' => route('pengawasan.detail', ['id' => $request->id]),
            'rapat' => $searchRapat,
            'dokumentasi' => $dokumentasi
        ];

        return view('pengawasan.form-dokumentasi', $data);
    }

    public function saveDokumentasi(Request $request): RedirectResponse
    {
        $year = date('Y');
        $month = date('m');
        $directory = 'images/pengawasan/' . $year . '/' . $month . '/';
        // this output directory : /images/pengawasan/2024/12/

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
        LogsModel::create(
            [
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'activity' => Auth::user()->name . ' Menyimpan dokumentasi pengawasan ' . $dokumentasi->perihal . ', timestamp' . now()
            ]
        );

        return redirect()->route('pengawasan.form-dokumentasi', ['id' => $request->input('id')])->with('success', 'Dokumentasi berhasil di simpan !');
    }

    public function deleteDokumentasi(Request $request): RedirectResponse
    {
        $dokumentasi = DokumentasiRapatModel::findOrFail(Crypt::decrypt($request->id));
        $detailRapat = DetailRapatModel::findOrFail($dokumentasi->detail_rapat_id);
        if ($dokumentasi) {
            // Delete old file pdf
            if (Storage::disk('public')->exists($dokumentasi->path_file_dokumentasi)) {
                Storage::disk('public')->delete($dokumentasi->path_file_dokumentasi);
            }
            // Saving logs activity
            LogsModel::create(
                [
                    'user_id' => Auth::user()->id,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'activity' => Auth::user()->name . ' Menghapus dokumentasi rapat ' . $detailRapat->perihal . ', timestamp' . now()
                ]
            );
            $dokumentasi->delete();
            return redirect()->back()->with('success', 'Dokumentasi berhasil di hapus !');
        }

        return redirect()->route('pengawasan.form-dokumentasi', ['id' => Crypt::encrypt($detailRapat->manajemen_rapat_id)])->with('error', 'Dokumentasi gagal di hapus !');
    }

    public function laporanPengawasan(Request $request)
    {
        // Get data rapat
        $searchRapat = ManajemenRapatModel::with('detailRapat')->findOrFail(Crypt::decrypt($request->id));
        $pengawasan = PengawasanBidangModel::with('temuanWasbid')->where('detail_rapat_id', '=', $searchRapat->detailRapat->id)->first();
        if ($pengawasan) {
            $kodePengawasan = $pengawasan->kode_pengawasan;
            $temuan = TemuanWasbidModel::where('pengawasan_bidang_id', '=', $pengawasan->id);
        } else {
            $kodePengawasan = Str::uuid();
            $temuan = null;
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengawasan Bidang', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat Pengawasan', 'link' => route('pengawasan.index'), 'page' => ''],
            ['title' => 'Laporan Pengawasan', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengawasan Bidang | ' . 'Laporan Pengawasan',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => 'Laporan Pengawasan',
            'routeBack' => route('pengawasan.detail', ['id' => $request->id]),
            'kodePengawasan' => $kodePengawasan,
            'rapat' => $searchRapat,
            'pengawasan' => $pengawasan,
            'temuan' => $temuan,
            'aplikasi' => AplikasiModel::first(),
            'unitKerja' => UnitKerjaModel::where('aktif', 'Y')->orderBy('unit_kerja', 'asc')->get(),
        ];

        return view('pengawasan.laporan-pengawasan', $data);
    }

    public function saveLaporan(Request $request): RedirectResponse
    {
        $paramIncoming = Crypt::decrypt($request->input('param'));
        // Search dokumen rapat
        $rapat = ManajemenRapatModel::with('detailRapat')->findOrFail(Crypt::decrypt($request->input('id')));
        $save = null;

        if ($paramIncoming == 'save') {
            // Search objek pengawasan
            $objek = UnitKerjaModel::findOrFail(htmlspecialchars($request->input('unitKerja')));
            // Search hakim pengawas
            $hakimWasbid = [];
            $unitKerja = htmlspecialchars($request->input('unitKerja'));

            $hakim = HakimPengawasModel::with([
                'pegawai' => function ($query) {
                    $query->orderBy('nip', 'desc');
                }
            ])->where('unit_kerja_id', '=', $unitKerja)->orderBy('ordering', 'asc');

            if ($hakim->exists()) {
                foreach ($hakim->get() as $kimwas) {
                    $hakimWasbid[] = [
                        'pegawai_id' => $kimwas->pegawai_id,
                        'nama' => $kimwas->pegawai->nama
                    ];
                }
            } else {
                return redirect()->back()->with('error', 'Hakim pengawas tidak tersedia ! Silahkan hubungi Superadmin atau Administrator');
            }

            // Run validated
            $request->validate(
                [
                    'unitKerja' => 'required|string',
                    'dasarHukum' => 'required|string',
                    'deskripsiPengawasan' => 'required|string'
                ],
                [
                    'unitKerja.required' => 'Objek/Unit Pengawasan harus di pilih !',
                    'unitKerja.string' => 'Objek/Unit Pengawasan harus berupa karakter valid !',
                    'dasarHukum.required' => 'Dasar Hukum Pengawasan harus di isi !',
                    'dasarHukum.string' => 'Dasar Hukum Pengawasan harus berupa karakter valid !',
                    'deskripsiPengawasan.required' => 'Deskripsi Pengawasan harus di isi !',
                    'deskripsiPengawasan.string' => 'Deskripsi Pengawasan harus berupa karakter valid !',
                ]
            );

            $formData = [
                'kode_pengawasan' => htmlspecialchars($request->input('kodePengawasan')),
                'detail_rapat_id' => $rapat->detailRapat->id,
                'objek_pengawasan' => $objek->unit_kerja,
                'dasar_hukum' => $request->input('dasarHukum'),
                'deskripsi_pengawasan' => $request->input('deskripsiPengawasan'),
                'hakim_pengawas' => json_encode($hakimWasbid),
                'status' => 'Waiting',
            ];

            // Checking exist pengawasan
            $pengawasan = PengawasanBidangModel::where('kode_pengawasan', '=', htmlspecialchars($request->input('kodePengawasan')))->first();
            if ($pengawasan) {
                $save = $pengawasan->update($formData);
                $success = 'Laporan berhasil di perbarui !';
                $error = 'Laporan gagal di perbarui !';
                $activity = Auth::user()->name . ' Menambahkan laporan pengawasan ' . $rapat->detailRapat->perihal . ', timestamp' . now();
            } else {
                $save = PengawasanBidangModel::create($formData);
                $success = 'Laporan berhasil di simpan !';
                $error = 'Laporan gagal di simpan !';
                $activity = Auth::user()->name . ' Memperbarui laporan pengawasan ' . $rapat->detailRapat->perihal . ', timestamp' . now();
            }

        } elseif ($paramIncoming == 'update') {

            // Run validated
            $request->validate(
                [
                    'kesimpulan' => 'required|string',
                    'rekomendasi' => 'required|string'
                ],
                [
                    'kesimpulan.required' => 'Kesimpulan harus di isi !',
                    'kesimpulan.string' => 'Kesimpulan harus berupa karakter valid !',
                    'rekomendasi.required' => 'Rekomendasi harus di isi !',
                    'rekomendasi.string' => 'Rekomendasi harus berupa karakter valid !',
                ]
            );

            $formData = [
                'kesimpulan' => htmlspecialchars($request->input('kesimpulan')),
                'rekomendasi' => htmlspecialchars($request->input('rekomendasi')),
            ];

            $pengawasan = PengawasanBidangModel::where('detail_rapat_id', '=', $rapat->detailRapat->id);
            $save = $pengawasan->update($formData);
            $success = 'Kesimpulan dan Rekomendasi berhasil di simpan !';
            $error = 'Kesimpulan dan Rekomendasi gagal di simpan !';
            $activity = Auth::user()->name . ' Menambahkan kesimpulan dan rekomendasi laporan pengawasan ' . $rapat->detailRapat->perihal . ', timestamp' . now();

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

        return redirect()->route('pengawasan.laporan', ['id' => $request->input('id')])->with('success', $success);
    }

    public function saveTemuan(TemuanWasbidRequest $request): RedirectResponse
    {
        // Run validate
        $request->validated();
        $save = null;

        // Search pengawasan on database, if not exists redirect back with error message
        $pengawasan = PengawasanBidangModel::findOrFail(Crypt::decrypt($request->input('idWasbid')));
        if (!$pengawasan) {
            return redirect()->back()->with('error', 'Data pengawasan tidak ditemukan !');
        }

        $formData = [
            'pengawasan_bidang_id' => Crypt::decrypt(htmlspecialchars($request->input('idWasbid'))),
            'objek_pengawasan' => $pengawasan->objek_pengawasan,
            'judul' => $request->input('judul'),
            'kondisi' => $request->input('kondisi'),
            'kriteria' => $request->input('kriteria'),
            'sebab' => $request->input('sebab'),
            'akibat' => $request->input('akibat'),
            'rekomendasi' => $request->input('rekomendasi'),
            'waktu_penyelesaian' => $request->input('waktuPenyelesaian'),
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));

        if ($paramIncoming == 'save') {
            $save = TemuanWasbidModel::create($formData);
            $success = 'Temuan berhasil di simpan !';
            $error = 'Temuan gagal di simpan !';
            $activity = Auth::user()->name . ' Menambahkan temuan ' . $pengawasan->kode_pengawasan . ', timestamp' . now();
        } elseif ($paramIncoming == 'update') {
            $searchTemuan = TemuanWasbidModel::findOrFail(Crypt::decrypt($request->input('idTemuan')));
            $save = $searchTemuan->update($formData);
            $success = 'Temuan berhasil di perbarui';
            $error = 'Temuan gagal di perbarui';
            $activity = Auth::user()->name . ' Memperbarui temuan ' . $pengawasan->kode_pengawasan . ', timestamp' . now();
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

        return redirect()->route('pengawasan.laporan', ['id' => htmlspecialchars($request->input('id'))])->with('success', $success);
    }

    public function deleteTemuan(Request $request)
    {
        $temuan = TemuanWasbidModel::findOrFail(Crypt::decrypt($request->id));
        if ($temuan) {
            // Saving logs activity
            LogsModel::create(
                [
                    'user_id' => Auth::user()->id,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'activity' => Auth::user()->name . ' Menghapus temuan' . $temuan->judul . ', timestamp ' . now()
                ]
            );
            $temuan->delete();
            return redirect()->back()->with('success', 'Temuan berhasil di hapus !');
        }
        return redirect()->back()->with('success', 'Temuan gagal di hapus !');
    }

    public function saveEdoc(Request $request): RedirectResponse
    {
        $year = date('Y');
        $month = date('m');
        $directory = 'pdf/pengawasan/' . $year . '/' . $month . '/';
        // this output directory : /pdf/pengawasan/2024/12/
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

        $rapat = DetailRapatModel::where('manajemen_rapat_id', '=', Crypt::decrypt($request->input('id')))->first();
        $pengawasan = PengawasanBidangModel::where('detail_rapat_id', '=', $rapat->id)->first();

        $formData = [
            'pengawasan_bidang_id' => $pengawasan->id,
            'path_file_tlhp' => $uploadPath,
        ];

        $existEdoc = EdocWasbidModel::where('pengawasan_bidang_id', '=', $pengawasan->id)->first();
        if ($existEdoc) {
            // Delete old file pdf
            if (Storage::disk('public')->exists($existEdoc->path_file_tlhp)) {
                Storage::disk('public')->delete($existEdoc->path_file_tlhp);
            }
            $save = $existEdoc->update($formData);
            $activity = Auth::user()->name . ' Memperbarui edoc pengawasan ' . $rapat->perihal . ', timestamp ' . now();
        } else {
            $save = EdocWasbidModel::create($formData);
            $activity = Auth::user()->name . ' Menambahkan edoc pengawasan ' . $rapat->perihal . ', timestamp ' . now();
        }

        if (!$save) {
            return redirect()->back()->with('error', 'File Edoc gagal di simpan !');
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

        return redirect()->route('pengawasan.detail', ['id' => $request->input('id')])->with('success', 'File Edoc berhasil di simpan !');
    }
}
