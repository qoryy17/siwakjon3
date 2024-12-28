<?php

namespace App\Http\Controllers\Pengaturan;

use Carbon\Carbon;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Models\Pengaturan\VersionModel;
use App\Models\Pengaturan\NoteDeveloperModel;
use App\Http\Requests\Pengaturan\VersionRequest;
use App\Http\Requests\Pengaturan\CatatanPengembangRequest;

class DevelopmentController extends Controller
{
    public function indexCatatanPengembang()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengaturan Aplikasi', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Catatan Pengembang', 'link' => route('aplikasi.pengembang'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengaturan Aplikasi | Catatan Pengembang',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'catatan' => NoteDeveloperModel::orderBy('created_at', 'desc')->get()
        ];

        return view('aplikasi.data-catatan-pengembang', $data);
    }

    public function formCatatanPengembang(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchCatatan = null;
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchCatatan = NoteDeveloperModel::findOrFail(Crypt::decrypt($request->id));
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengaturan Aplikasi', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Catatan Pengembang', 'link' => route('aplikasi.pengembang'), 'page' => ''],
            ['title' => $formTitle . ' Catatan Pengembang', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengaturan Aplikasi | ' . $formTitle . ' Catatan Pengembang',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Catatan Pengembang',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'catatan' => $searchCatatan
        ];

        return view('aplikasi.form-catatan-pengembang', $data);
    }

    public function saveCatatanPengembang(CatatanPengembangRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'catatan' => $request->input('catatan'),
            'pengembang' => Auth::user()->id,
            'aktif' => htmlspecialchars($request->input('aktif')),
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            $save = NoteDeveloperModel::create($formData);
            $success = 'Catatan berhasil di simpan !';
            $error = 'Catatan gagal di simpan !';
        } elseif ($paramIncoming == 'update') {
            $search = NoteDeveloperModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Catatan berhasil di perbarui !';
            $error = 'Catatan gagal di perbarui !';
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !')->withInput();
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->route('aplikasi.pengembang')->with('success', $success);
    }

    public function deleteCatatanPengembang(Request $request): RedirectResponse
    {
        // Checking data catatan on database
        $catatan = NoteDeveloperModel::findOrFail(Crypt::decrypt($request->id));
        if ($catatan) {
            $catatan->delete();
            return redirect()->route('aplikasi.pengembang')->with('success', 'Catatan pengembang berhasil di hapus !');
        }
        return redirect()->route('aplikasi.pengembang')->with('error', 'Catatan pengembang gagal di hapus !');
    }

    public function indexVersion()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengaturan Aplikasi', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Version', 'link' => route('aplikasi.pengembang'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengaturan Aplikasi | Version',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'version' => VersionModel::orderBy('created_at', 'desc')->get()
        ];

        return view('aplikasi.data-versi', $data);
    }

    public function formVersion(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $searchVersion = null;
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $searchVersion = VersionModel::findOrFail(Crypt::decrypt($request->id));
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengaturan Aplikasi', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Version', 'link' => route('aplikasi.version'), 'page' => ''],
            ['title' => $formTitle . ' Version', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengaturan Aplikasi | ' . $formTitle . ' Version',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Version',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'version' => $searchVersion
        ];

        return view('aplikasi.form-versi', $data);
    }

    public function saveVersion(VersionRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $formData = [
            'release_date' => Carbon::createFromFormat('m/d/Y', htmlentities($request->input('releaseDate')))->format('Y-m-d'),
            'category' => htmlspecialchars($request->input('category')),
            'patch_version' => htmlspecialchars($request->input('patchVersion')),
            'note' => nl2br($request->input('note'))
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            $save = VersionModel::create($formData);
            $success = 'Version berhasil di simpan !';
            $error = 'Version gagal di simpan !';
        } elseif ($paramIncoming == 'update') {
            $search = VersionModel::findOrFail(Crypt::decrypt($request->input('id')));
            $save = $search->update($formData);
            $success = 'Version berhasil di perbarui !';
            $error = 'Version gagal di perbarui !';
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !');
        }

        if (!$save) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->route('aplikasi.version')->with('success', $success);
    }

    public function deleteVersion(Request $request): RedirectResponse
    {
        // Checking data version on database
        $version = VersionModel::findOrFail(Crypt::decrypt($request->id));
        if ($version) {
            $version->delete();
            return redirect()->route('aplikasi.version')->with('success', 'Version berhasil di hapus !');
        }
        return redirect()->route('aplikasi.version')->with('error', 'Version gagal di hapus !');
    }
}
