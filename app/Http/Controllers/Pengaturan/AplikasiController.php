<?php

namespace App\Http\Controllers\Pengaturan;

use App\Helpers\RouteLink;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengaturan\AplikasiModel;
use App\Http\Requests\Pengaturan\AplikasiRequest;

class AplikasiController extends Controller
{
    public function indexKonfigurasi()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Pengaturan Aplikasi', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Konfigurasi', 'link' => route('aplikasi.konfigurasi'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Pengaturan Aplikasi | Konfigurasi',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'konfigurasi' => AplikasiModel::first()
        ];
        return view('aplikasi.konfigurasi', $data);

    }

    public function save(AplikasiRequest $request): RedirectResponse
    {
        // Run validated requests
        $request->validated();

        $formData = [
            'lembaga' => htmlspecialchars($request->input('lembaga')),
            'badan_peradilan' => htmlspecialchars($request->input('badanPeradilan')),
            'wilayah_hukum' => htmlspecialchars($request->input('wilayahHukum')),
            'kode_satker' => htmlspecialchars($request->input('kodeSatker')),
            'satuan_kerja' => htmlspecialchars($request->input('satuanKerja')),
            'alamat' => htmlspecialchars($request->input('alamat')),
            'provinsi' => htmlspecialchars($request->input('provinsi')),
            'kota' => htmlspecialchars($request->input('kota')),
            'kode_pos' => htmlspecialchars($request->input('kodePos')),
            'telepon' => htmlspecialchars($request->input('telepon')),
            'email' => htmlspecialchars($request->input('email')),
            'website' => htmlspecialchars($request->input('website')),
        ];

        $save = null;
        $directory = 'images/config/';

        // Check available data on sw_pengaturan
        $setting = AplikasiModel::first();
        if (!$setting) {
            // Run validated if logo has found
            $request->validate(
                ['logo' => 'required|file|image|mimes:png,jpg|max:5012'],
                [
                    'logo.required' => 'Logo harus di isi !',
                    'logo.file' => 'Logo harus berupa file !',
                    'logo.image' => 'Logo harus berupa image ',
                    'logo.mimes' => 'Logo harus berupa bertipe png/jpg ',
                    'logo.max' => 'Logo maksimal 5MB'
                ]
            );

            // Logo upload process
            $fileLogo = $request->file('logo');
            $fileHashname = $fileLogo->hashName();
            $uploadPath = $directory . $fileHashname;
            $fileUpload = $fileLogo->storeAs($directory, $fileHashname, 'public');

            // If logo has failed to upload
            if (!$fileUpload) {
                return redirect()->back()->with('error', 'Unggah logo gagal !')->withInput();
            }
            $formData['logo'] = $uploadPath;

            // Save data
            $save = AplikasiModel::create($formData);
            $success = 'Pengaturan berhasil di simpan !';
            $error = 'Pengaturan gagal di simpan !';
        } else {
            // Run validated if logo has found
            $request->validate(
                ['logo' => 'file|image|mimes:png,jpg|max:5012'],
                [
                    'logo.file' => 'Logo harus berupa file !',
                    'logo.image' => 'Logo harus berupa image ',
                    'logo.mimes' => 'Logo harus berupa bertipe png/jpg ',
                    'logo.max' => 'Logo maksimal 5MB'
                ]
            );

            if ($request->file('logo')) {
                // Delete old logo
                if (Storage::disk('public')->exists($directory . $setting->logo)) {
                    Storage::disk('public')->delete($directory . $setting->logo);
                }

                // Logo upload process
                $fileLogo = $request->file('logo');
                $fileHashname = $fileLogo->hashName();
                $uploadPath = $directory . $fileHashname;
                $fileUpload = $fileLogo->storeAs($directory, $fileHashname, 'public');

                // If logo has failed to upload
                if (!$fileUpload) {
                    return redirect()->back()->with('error', 'Unggah logo gagal !')->withInput();
                }
                $formData['license'] = '-';
                $formData['logo'] = $uploadPath;
            }

            // Update data
            $save = $setting->update($formData);
            $success = 'Pengaturan berhasil di perbarui !';
            $error = 'Pengaturan gagal di perbarui !';
        }

        if (!$save) {
            return redirect()->back()->with('error', $error)->withInput();
        }

        return redirect()->route('aplikasi.konfigurasi')->with('success', $success);
    }

}
