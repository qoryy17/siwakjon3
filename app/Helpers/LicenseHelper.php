<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
use App\Models\Pengaturan\AplikasiModel;
use Illuminate\Http\RedirectResponse;

class LicenseHelper
{
    public static function checkLicenseDB()
    {
        // Get License from database
        $dbLicense = AplikasiModel::first();

        $data = [
            'title' => 'License Serial Number',
            'license' => AplikasiModel::first(),
        ];

        if (!$dbLicense) {
            // Serial number is null
            $data['status'] = null;
            $data['message'] = 'Licensi masa aktif kosong, silahkan aktivasi dengan serial number valid !';
            $data['title'] = 'License Is Empty !';
            return view('maintance.license', $data);
        }


        // Handle error if decryption is failed
        try {
            // Decrypt and convert license to base64_decode
            $licenseFromDB = base64_decode(Crypt::decryptString($dbLicense->license));
        } catch (\Throwable $th) {
            // return response()->view('errors.500', [], 500);
            $data['status'] = 'Invalid';
            $data['message'] = 'License serial number yang di masukan tidak valid !';
            $data['title'] = 'License Is Invalid !';
            session()->flash('error', $th->getMessage());
            return view('maintance.license', $data);
        }

        // Read file license.ini from storage
        $path = storage_path('app/private/license.ini');
        $contents = file_get_contents($path);
        $iniFile = parse_ini_string($contents, true);

        // Get unique key form license.ini
        $licenseFromFile = $iniFile['License'];

        $licenseFile = base64_decode((Crypt::decryptString($licenseFromFile['serial_number'])));

        // Date now
        $date = date('d-m-Y');

        // Checking serial number between from database and license.ini
        if ($licenseFile == $licenseFromDB) {
            if ($date < base64_decode(Crypt::decryptString($licenseFromFile['date_expired']))) {
                // License valid to using
                $data['status'] = 'Active';
                $data['message'] = 'License masa aktif aplikasi valid dan berlaku !';
                $data['title'] = 'License Is Active !';
            } else {
                // License has expired to use
                $data['status'] = 'Expired';
                $data['message'] = 'License masa aktif aplikasi telah berakhir, silahkan aktivasi ulang dengan license serial number terbaru !';
                $data['title'] = 'License Is Expired !';
            }
            return view('maintance.license', $data);
        }

        // Serial number doesn't match
        $data['status'] = 'Not Match';
        $data['message'] = 'Licensi masa aktif invalid !';
        $data['title'] = 'License Is Invalid !';
        return view('maintance.license', $data);
    }

    public static function checkLicenseMiddleware()
    {
        // Get License from database
        $dbLicense = AplikasiModel::first();

        if (!$dbLicense) {
            return redirect()->route('license.index');
        }

        // Handle error if decryption is failed
        try {
            // Decrypt and convert license to base64_decode
            $licenseFromDB = base64_decode(Crypt::decryptString($dbLicense->license));
        } catch (\Throwable $th) {
            // return response()->view('errors.500', [], 500);
            return redirect()->route('license.index');
        }

        // Read file license.ini from storage
        $path = storage_path('app/private/license.ini');
        $contents = file_get_contents($path);
        $iniFile = parse_ini_string($contents, true);

        // Get unique key form license.ini
        $licenseFromFile = $iniFile['License'];

        $licenseFile = base64_decode((Crypt::decryptString($licenseFromFile['serial_number'])));

        // Date now
        $date = date('d-m-Y');

        // Checking serial number between from database and license.ini
        if ($licenseFile == $licenseFromDB) {
            if ($date < base64_decode(Crypt::decryptString($licenseFromFile['date_expired']))) {
                return;
            } else {
                // License has expired to use
                return redirect()->route('license.index');
            }
        }
        return redirect()->route('license.index');
    }
}
