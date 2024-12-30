<?php

namespace App\Http\Controllers\Manajemen;

use Carbon\Carbon;
use App\Helpers\RouteLink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pengaturan\LogsModel;
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
            'title' => 'Pengawasan Bidang',
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
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchKunjungan = KunjunganPengawasanModel::findOrFail(Crypt::decrypt($request->id));
            $kodeKunjungan = $searchKunjungan->kode_kunjungan;
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
            'kodeKunjungan' => $kodeKunjungan
        ];

        return view('pengawasan.form-kunjungan', $data);
    }

    public function detailKunjungan(Request $request)
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $hakim = HakimPengawasModel::with('pegawai')->whereHas('pegawai', function ($query) {
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

        if ($paramIncoming == 'save') {
            $formData['dibuat'] = Auth::user()->id;
            $save = KunjunganPengawasanModel::create($formData);
            $activity = Auth::user()->name . ' Menambahkan kunjungan ' . $formData['kode_kunjungan'] . ', timestamp ' . now();
            $success = 'Kunjungan berhasil di simpan !';
            $error = 'Kunjungan gagal di simpan !';
            $routeBack = redirect()->route('kunjungan.index')->with('success', $success);
        } elseif ($paramIncoming == 'update') {
            $search = KunjunganPengawasanModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Kunjungan berhasil di perbarui !';
            $error = 'Kunjungan gagal di perbarui !';
            $activity = Auth::user()->name . ' Memperbarui kunjungan ' . $formData['kode_kunjungan'] . ', timestamp ' . now();
            $routeBack = redirect()->route('kunjungan.detail', ['id' => $request->input('id')])->with('success', $success);
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
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

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        return $routeBack;
    }

    public function deleteKunjungan(Request $request): RedirectResponse
    {
        $kunjungan = KunjunganPengawasanModel::findOrFail(Crypt::decrypt($request->id));
        if ($kunjungan) {

            // Delete file edoc pdf
            if (Storage::disk('public')->exists($kunjungan->path_file_edoc)) {
                Storage::disk('public')->delete($kunjungan->path_file_edoc);
            }

            $detailKunjungan = DetailKunjunganModel::where('kunjungan_pengawasan_id', '=', $kunjungan->id)->first();
            if ($detailKunjungan) {
                $detailKunjungan->delete();
            }
            // Saving logs activity
            LogsModel::create(
                [
                    'user_id' => Auth::user()->id,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'activity' => Auth::user()->name . 'Menghapus kunjungan ' . $kunjungan->kode_kunjungan . ', timestamp ' . now()
                ]
            );

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
            'pembahasan' => nl2br($request->input('pembahasan')),
            'hakim_pengawas_id' => htmlspecialchars($request->input('hakim')),
        ];

        if ($paramIncoming == 'save') {
            $save = DetailKunjunganModel::create($formData);
            $activity = Auth::user()->name . ' Menambahkan agenda kunjungan ' . $formData['agenda'] . ', timestamp ' . now();
            $success = 'Agenda Kunjungan berhasil di simpan !';
            $error = 'Agenda Kunjungan gagal di simpan !';
        } elseif ($paramIncoming == 'update') {
            $search = DetailKunjunganModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Agenda Kunjungan berhasil di perbarui !';
            $error = 'Agenda Kunjungan gagal di perbarui !';
            $activity = Auth::user()->name . ' Memperbarui agenda kunjungan dengan id ' . $request->input('id') . ', timestamp ' . now();
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
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

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->route('kunjungan.detail', ['id' => $request->input('idKunjungan')])->with('success', $success);
    }

    public function deleteAgenda(Request $request): RedirectResponse
    {
        $detailKunjungan = DetailKunjunganModel::findOrFail(Crypt::decrypt($request->id));
        if ($detailKunjungan) {
            // Saving logs activity
            LogsModel::create(
                [
                    'user_id' => Auth::user()->id,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'activity' => Auth::user()->name . 'Menghapus agenda kunjungan ' . $detailKunjungan->agenda . ', timestamp ' . now()
                ]
            );
            $detailKunjungan->delete();
            return redirect()->route('kunjungan.detail', ['id' => Crypt::encrypt($detailKunjungan->kunjungan_pengawasan_id)])->with('success', 'Agenda Kunjungan berhasil di hapus !');
        }

        return redirect()->route('kunjungan.detail', ['id' => Crypt::encrypt($detailKunjungan->kunjungan_pengawasan_id)])->with('error', 'Agenda Kunjungan gagal di hapus !');
    }
}
