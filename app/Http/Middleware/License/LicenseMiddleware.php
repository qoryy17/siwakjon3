<?php

namespace App\Http\Middleware\License;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\LicenseHelper;
use Illuminate\Support\Facades\Crypt;
use App\Models\Pengaturan\AplikasiModel;
use Symfony\Component\HttpFoundation\Response;

class LicenseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Before entry system application, check validation license from database on file

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
                return $next($request);
            } else {
                // License has expired to use
                return redirect()->route('license.index');
            }
        }
        return redirect()->route('license.index');
    }
}
