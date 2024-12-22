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
use App\Models\Manajemen\DetailRapatModel;
use App\Models\Pengaturan\SetKodeRapatModel;
use App\Models\Manajemen\ManajemenRapatModel;
use App\Models\Pengguna\PejabatPenggantiModel;
use App\Models\Manajemen\KlasifikasiRapatModel;
use App\Models\Manajemen\KlasifikasiJabatanModel;
use App\Http\Requests\Manajemen\FormManajemenRapat;
use App\Http\Requests\Manajemen\FormNotulaRequest;
use App\Http\Requests\Manajemen\FormUndanganRapatRequest;

class RapatController extends Controller
{
    public function indexRapat()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Rapat', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Rapat Dinas', 'link' => route('rapat.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'klasifikasiRapat' => KlasifikasiRapatModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'klasifikasiJabatan' => KlasifikasiJabatanModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'rapat' => ManajemenRapatModel::with('detailRapat')->orderBy('created_at', 'desc')->get()
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

        $data = [
            'title' => 'Manajemen Rapat | Detail Rapat',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'rapat' => ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id))->first()
        ];
        return view('rapat.detail-rapat', $data);
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

            // Search klasifikasi jabatan on database
            $klasifikasiJabatan = KlasifikasiJabatanModel::findOrFail($request->input('klasifikasiJabatan'));
            if (!$klasifikasiJabatan) {
                return redirect()->back()->with('error', 'Klasifikasi Jabatan tidak ditemukan !');
            }

            // Generate index nomor dokumen rapat
            $indexNumber = ManajemenRapatModel::orderBy('nomor_indeks', 'desc')->lockForUpdate()->first();
            $indexIncrement = intval($indexNumber->nomor_indeks) + 1;

            // Get Set Kode Surat on database
            $searchKodeSurat = SetKodeRapatModel::first();
            if (!$searchKodeSurat) {
                return redirect()->back()->with('error', 'Kode Surat belum di set !');
            }

            // Generate nomor dokumen rapat
            $nomorDokumen = $indexIncrement . '/' . $klasifikasiJabatan->kode_jabatan . '.' . 'W2-U4/' . $searchKodeSurat->kode_rapat_dinas . '/' . TimeSession::convertMonthToRoman() . '/' . date('Y');

            // Set value klasifikasi for form
            $klasifikasi = ['rapat' => Crypt::encrypt($klasifikasiRapat->id), 'jabatan' => $klasifikasiJabatan->jabatan];

        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $routeBack = route('rapat.index');
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

    public function saveRapat(FormManajemenRapat $request, FormUndanganRapatRequest $requestRapat)//: RedirectResponse
    {
        // Run validated
        $request->validated();
        $requestRapat->validated();

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;
        $saveDetailRapat = null;

        $uniqueKodeRapat = Str::uuid();

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
                if (htmlspecialchars($request->input('pejabatPengganti'))) {
                    $formData['pejabat_pengganti_id'] = htmlspecialchars($request->input('pejabatPengganti'));
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
                    'agenda' => nl2br(htmlspecialchars($requestRapat->input('agenda'))),
                    'jam_mulai' => htmlspecialchars($requestRapat->input('jamRapat')),
                    'tempat' => htmlspecialchars($requestRapat->input('tempat')),
                    'peserta' => htmlspecialchars($requestRapat->input('peserta')),
                    'keterangan' => $requestRapat->input('keterangan'),
                ];
                DetailRapatModel::create($formDetailRapat);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', $th);
            }
            $success = 'Dokumen Rapat berhasil di simpan !';
            $error = 'Dokumen Rapat gagal di simpan !';
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
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        if (!$saveDetailRapat) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->route('rapat.index')->with('success', $success);
    }

    public function deleteRapat(Request $request): RedirectResponse
    {
        // Checking data manajemen rapat on database
        $rapat = ManajemenRapatModel::findOrFail(Crypt::decrypt($request->id));
        if ($rapat) {
            $detailRapat = DetailRapatModel::where('manajemen_rapat_id', '=', $rapat->id);
            if ($detailRapat) {
                $detailRapat->delete();
            }
            $rapat->delete();
            return redirect()->route('rapat.index')->with('success', 'Rapat berhasil di hapus !');
        }
        return redirect()->route('rapat.index')->with('error', 'Rapat gagal di hapus !');
    }

    public function formNotula(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $routeBack = route('rapat.detail', ['id' => 'null']);
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $routeBack = route('rapat.detail', ['id' => 'null']);
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        $searchRapat = ManajemenRapatModel::with('detailRapat')->findOrFail(Crypt::decrypt($request->id));

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
            'routeBack' => $routeBack,
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'pegawai' => PegawaiModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get(),
            'rapat' => $searchRapat
        ];

        return view('rapat.form-notula', $data);
    }

    public function saveNotula(FormNotulaRequest $request)
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

        return redirect()->route('rapat.detail', ['id' => $request->input('id')])->with('success', 'Notula berhasil di simpan !');
    }

    public function formDokumentasi(Request $request)
    {
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
            'formTitle' => 'Dokumentasi ',
            'routeBack' => route('rapat.index')
        ];

        return view('rapat.form-dokumentasi', $data);
    }
}
