<?php

namespace App\Http\Controllers;

use App\Helpers\LicenseHelper;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Pengaturan\AplikasiModel;

class LicenseController extends Controller
{
    public function index(Request $request)
    {
        return LicenseHelper::checkLicenseDB();
    }

    public function saveLicense(Request $request): RedirectResponse
    {
        // Run validate
        $request->validate(
            ['license' => 'required|string'],
            ['license.required' => 'Lisensi serial number harus di isi !', 'Lisensi serial number harus berupa karakter valid !']
        );

        $license = $request->input('license');

        $dbLicense = AplikasiModel::first();

        if ($dbLicense) {
            $dbLicense->update(['license' => $license]);
            // If activate has been success redirect to signin page
            return redirect()->route('license.index')->with('success', 'License berhasil di simpan !');
        }

        // If activate isn't success redirect back
        return redirect()->back()->with('error', value: 'Aktivasi Lisensi gagal !');
    }


}
