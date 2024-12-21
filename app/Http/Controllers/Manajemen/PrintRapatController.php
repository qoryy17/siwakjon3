<?php

namespace App\Http\Controllers\Manajemen;

use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Support\Facades\Crypt;
use App\Models\Pengaturan\AplikasiModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Manajemen\ManajemenRapatModel;

class PrintRapatController extends Controller
{
    public function printUndanganRapat(Request $request)
    {
        // Generate QR code
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id))->first();
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = base64_encode(QrCode::format('png')->size(60)->generate($url));
        $pegawai = PegawaiModel::with('jabatan')->findOrFail($rapat->pejabat_penandatangan);
        $data = [
            'aplikasi' => AplikasiModel::first(),
            'rapat' => $rapat,
            'qrCode' => $qrCode,
            'pegawai' => $pegawai
        ];
        $pdf = PDF::loadView('template.pdf-undangan-rapat', $data);
        $pdf->setPaper('Folio', 'potrait');
        return $pdf->stream('Undangan Rapat' . $rapat->perihal . ' ' . $rapat->detailRapat->tanggal_rapat . '.pdf');
        // return view('template.pdf-undangan-rapat', $data);
    }
    public function printAbsensiRapat(Request $request)
    {

    }

    public function printNotulaRapat(Request $request)
    {

    }

    public function printDokumentasiRapat(Request $request)
    {

    }


}
