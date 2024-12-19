<?php

namespace App\Http\Controllers\Arsip;

use Carbon\Carbon;
use App\Helpers\RouteLink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Arsip\ArsipMonevModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\Arsip\AgendaMonevModel;
use App\Models\Arsip\PeriodeMonevModel;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Monev\MonevRequest;
use App\Models\Pengaturan\UnitKerjaModel;
use App\Http\Requests\Monev\AgendaMonevRequest;
use App\Http\Requests\Monev\PeriodeMonevRequest;

class MonevController extends Controller
{
    public function indexMonev()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $monev = DB::table('sw_agenda_monev')->select('sw_agenda_monev.*', 'sw_unit_kerja.unit_kerja')->leftjoin(
            'sw_unit_kerja',
            'sw_agenda_monev.unit_kerja_id',
            '=',
            'sw_unit_kerja.id'
        )->orderBy('created_at', 'desc')->get();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Monev', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Laporan Monev', 'link' => route('monev.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Monev | Laporan Monev',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'monev' => $monev
        ];

        return view('monev.data-monev', $data);
    }

    public function formAgendaMonev(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchAgendaMonev = null;
            $nomorAgenda = Str::uuid();
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchAgendaMonev = AgendaMonevModel::findOrFail(Crypt::decrypt($request->id));
            $nomorAgenda = $searchAgendaMonev->nomor_agenda;
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Monev', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Agenda Monev', 'link' => route('monev.index'), 'page' => ''],
            ['title' => $formTitle . ' Agenda Monev', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Monev | ' . $formTitle . ' Periode Monev',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Periode Monev',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'agendaMonev' => $searchAgendaMonev,
            'nomorAgenda' => $nomorAgenda,
            'unitKerja' => UnitKerjaModel::where('aktif', '=', 'Y')->orderBy('unit_kerja', 'asc')->get()
        ];

        return view('monev.form-agenda-monev', $data);
    }

    public function saveAgendaMonev(AgendaMonevRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'nomor_agenda' => htmlspecialchars($request->input('nomorAgenda')),
            'nama_agenda' => htmlspecialchars($request->input('namaAgenda')),
            'unit_kerja_id' => htmlspecialchars($request->input('unitKerja')),
            'aktif' => htmlspecialchars($request->input('aktif')),
            'dibuat' => Auth::user()->id,
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            $save = AgendaMonevModel::create($formData);
            $success = 'Agenda Monev berhasil di simpan !';
            $error = 'Agenda Monev gagal di simpan !';
        } elseif ($paramIncoming == 'update') {
            $search = AgendaMonevModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Agenda Monev berhasil di perbarui !';
            $error = 'Agenda Monev gagal di perbarui !';
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->route('monev.index')->with('success', $success);
    }

    public function deleteAgendaMonev(Request $request): RedirectResponse
    {
        // Checking data agenda monev on database
        $agendaMonev = AgendaMonevModel::findOrFail(Crypt::decrypt($request->id));
        if ($agendaMonev) {
            ArsipMonevModel::where('agenda_monev_id', '=', $agendaMonev->id)->delete();
            $agendaMonev->delete();
            return redirect()->route('monev.index')->with('success', 'Agenda Monev berhasil di hapus !');
        }
        return redirect()->route('monev.index')->with('error', 'Agenda Monev gagal di hapus !');
    }

    public function detailAgendaMonev(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        // Search relatedness monev
        $searchAgendaMonev = AgendaMonevModel::with('unitKerja')->findOrFail(Crypt::decrypt($request->id));
        $periodeMonev = PeriodeMonevModel::where('aktif', '=', 'Y')->orderBy('created_at', 'desc')->get();
        $arsipMonev = ArsipMonevModel::with('periodeMonev')->where('agenda_monev_id', '=', $searchAgendaMonev->id)->orderBy('created_at', 'desc')->get();

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Monev', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Detail Agenda Monev', 'link' => route('monev.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Monev | Detail Agenda Monev',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => 'Agenda Monitoring dan Evaluasi ' . $searchAgendaMonev->unitKerja->unit_kerja,
            'agendaMonev' => $searchAgendaMonev,
            'periodeMonev' => $periodeMonev,
            'detailMonev' => $arsipMonev
        ];

        return view('monev.detail-agenda-monev', $data);
    }

    public function saveMonev(MonevRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'agenda_monev_id' => Crypt::decrypt(htmlspecialchars($request->input('nomorAgenda'))),
            'judul_monev' => htmlspecialchars($request->input('judulMonev')),
            'tanggal_monev' => Carbon::createFromFormat('m/d/Y', htmlentities($request->input('tanggalMonev')))->format('Y-m-d'),
            'periode_monev_id' => htmlspecialchars($request->input('periode')),
            'status' => 'Menunggu'
        ];

        try {
            DB::beginTransaction();
            $save = ArsipMonevModel::create($formData);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th);
        }

        if (!$save) {
            return redirect()->back()->with('error', 'Monev gagal di simpan !');
        }
        return redirect()->route('monev.detailAgendaMonev', ['id' => Crypt::encrypt($formData['agenda_monev_id'])])->with('success', 'Monev berhasil di simpan !');
    }

    public function updateMonev(MonevRequest $request): RedirectResponse
    {
        // Run validated
        $request->validate([
            'idAgenda' => 'required|string'
        ], [
            'idAgenda.required' => 'ID Agenda harus di isi !',
            'idAgenda.string' => 'ID Agenda harus berupa karakter valid !',
        ]);
        $request->validated();

        $formData = [
            'agenda_monev_id' => Crypt::decrypt(htmlspecialchars($request->input('nomorAgenda'))),
            'judul_monev' => htmlspecialchars($request->input('judulMonev')),
            'tanggal_monev' => Carbon::createFromFormat('m/d/Y', htmlentities($request->input('tanggalMonev')))->format('Y-m-d'),
            'periode_monev_id' => htmlspecialchars($request->input('periode')),
        ];

        try {
            DB::beginTransaction();
            $search = ArsipMonevModel::findOrFail(Crypt::decrypt(htmlspecialchars($request->input('idAgenda'))));
            $save = $search->update($formData);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th);
        }

        if (!$save) {
            return redirect()->back()->with('error', 'Monev gagal di perbarui !');
        }

        return redirect()->route('monev.detailAgendaMonev', ['id' => Crypt::encrypt($formData['agenda_monev_id'])])->with('success', 'Monev berhasil di perbarui !');
    }

    public function deleteMonev(Request $request): RedirectResponse
    {
        // Checking data monev on database
        $arsipMonev = ArsipMonevModel::findOrFail(Crypt::decrypt($request->id));
        if ($arsipMonev) {
            $arsipMonev->delete();
            return redirect()->route('monev.detailAgendaMonev', ['id' => Crypt::encrypt($arsipMonev->agenda_monev_id)])->with('success', 'Monev berhasil di hapus !');
        }
        return redirect()->route('monev.detailAgendaMonev', ['id' => Crypt::encrypt($arsipMonev->agenda_monev_id)])->with('error', 'Monev gagal di hapus !');
    }

    public function unggahMonev(Request $request): RedirectResponse
    {
        // Run validate
        $request->validate([
            'idAgenda' => 'required|string',
            'fileMonev' => 'required|file|mimes:pdf|max:10240'
        ], [
            'idAgenda.required' => 'ID Agenda harus di isi !',
            'idAgenda.string' => 'ID Agenda harus berupa karakter valid !',
            'fileMonev.required' => 'File laporan monev wajib di isi !',
            'fileMonev.file' => 'File laporan monev harus berupa file valid !',
            'fileMonev.mimes' => 'File laporan monev hanya boleh bertipe pdf',
            'fileMonev.max' => 'File laporan monev maksimal berukuran 10MB',
        ]);

        $month = date('m');
        $year = date('Y');
        $directory = 'pdf/arsip-monev/' . $month . '/' . $year . '/';
        // this output directory : /pdf/arsip-monev/1/2024/

        $formData = [
            'agenda_monev_id' => Crypt::decrypt(htmlspecialchars($request->input('nomorAgenda'))),
        ];

        // Deadline checking monev
        try {
            DB::beginTransaction();
            $search = ArsipMonevModel::findOrFail(Crypt::decrypt(htmlspecialchars($request->input('idAgenda'))));

            if ($search && $search->path_monev != null) {
                // Delete old file pdf
                if (Storage::disk('public')->exists($search->path_monev)) {
                    Storage::disk('public')->delete($search->path_monev);
                }

                // File pdf upload process
                $fileMonev = $request->file('fileMonev');
                $fileHashname = $fileMonev->hashName();
                $uploadPath = $directory . $fileHashname;
                $fileUpload = $fileMonev->storeAs($directory, $fileHashname, 'public');

                // If file pdf has failed to upload
                if (!$fileUpload) {
                    return redirect()->back()->with('error', 'Unggah file gagal !')->withInput();
                }

                $formData['path_monev'] = $uploadPath;
            } else {

                // File pdf upload process
                $fileMonev = $request->file('fileMonev');
                $fileHashname = $fileMonev->hashName();
                $uploadPath = $directory . $fileHashname;
                $fileUpload = $fileMonev->storeAs($directory, $fileHashname, 'public');

                // If file pdf has failed to upload
                if (!$fileUpload) {
                    return redirect()->back()->with('error', 'Unggah file gagal !')->withInput();
                }

                $formData['path_monev'] = $uploadPath;
            }

            // Checking status unggah according to the current time
            if (now() > $search->created_at) {
                $statusUnggah = 'Terlambat';
            } elseif (now() < $search->created_at) {
                $statusUnggah = 'Tepat Waktu';
            } else {
                $statusUnggah = 'Menunggu';
            }

            $formData['status'] = $statusUnggah;
            $formData['diunggah'] = Auth::user()->id;
            $formData['waktu_unggah'] = now();

            $save = $search->update($formData);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th);
        }

        if (!$save) {
            return redirect()->back()->with('error', 'Laporan monev gagal diunggah !');
        }

        return redirect()->route('monev.detailAgendaMonev', ['id' => Crypt::encrypt($formData['agenda_monev_id'])])->with('success', 'Laporan monev berhasil diunggah !');
    }

    public function indexPeriodeMonev()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Monev', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Periode Monev', 'link' => route('monev.index'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Monev | Periode Monev',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'periodeMonev' => PeriodeMonevModel::orderBy('created_at', 'desc')->get()
        ];

        return view('monev.data-periode-monev', $data);
    }

    public function formPeriodeMonev(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchPeriodeMonev = null;
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchPeriodeMonev = PeriodeMonevModel::findOrFail(Crypt::decrypt($request->id));
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Monev', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Periode Monev', 'link' => route('monev.periode'), 'page' => ''],
            ['title' => $formTitle . ' Periode Monev', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Monev | ' . $formTitle . ' Periode Monev',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Periode Monev',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'periode' => $searchPeriodeMonev
        ];

        return view('monev.form-periode-monev', $data);
    }

    public function savePeriodeMonev(PeriodeMonevRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'periode' => htmlspecialchars($request->input('periode')),
            'aktif' => htmlspecialchars($request->input('aktif')),
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            $save = PeriodeMonevModel::create($formData);
            $success = 'Periode Monev berhasil di simpan !';
            $error = 'Periode Monev gagal di simpan !';
        } elseif ($paramIncoming == 'update') {
            $search = PeriodeMonevModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Periode Monev berhasil di perbarui !';
            $error = 'Periode Monev gagal di perbarui !';
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->route('monev.periode')->with('success', $success);
    }

    public function deletePeriodeMonev(Request $request): RedirectResponse
    {
        // Checking data periode monev on database
        $periodeMonev = PeriodeMonevModel::findOrFail(Crypt::decrypt($request->id));
        if ($periodeMonev) {
            $periodeMonev->delete();
            return redirect()->route('monev.periode')->with('success', 'Periode Monev berhasil di hapus !');
        }
        return redirect()->route('monev.periode')->with('error', 'Periode Monev gagal di hapus !');
    }
}
