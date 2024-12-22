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
        return $pdf->stream('Undangan Rapat ' . $rapat->perihal . ' ' . $rapat->detailRapat->tanggal_rapat . '.pdf');
    }
    public function printDaftarHadirRapat(Request $request)
    {
        $peserta = $request->jumlahPeserta;
        // Generate QR code
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id))->first();
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = base64_encode(QrCode::format('png')->size(60)->generate($url));
        $data = [
            'aplikasi' => AplikasiModel::first(),
            'rapat' => $rapat,
            'qrCode' => $qrCode,
            'peserta' => $peserta
        ];
        $pdf = PDF::loadView('template.pdf-daftar-hadir-rapat', $data);
        $pdf->setPaper('Folio', 'potrait');
        return $pdf->stream('Daftar Hadir Rapat ' . $rapat->perihal . ' ' . $rapat->detailRapat->tanggal_rapat . '.pdf');
    }

    public function printNotulaRapat(Request $request)
    {
        // Generate QR code
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id))->first();
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = base64_encode(QrCode::format('png')->size(60)->generate($url));

        $notulis = PegawaiModel::findOrFail($rapat->detailRapat->notulen);
        $disahkan = PegawaiModel::findOrFail($rapat->detailRapat->disahkan);
        $data = [
            'aplikasi' => AplikasiModel::first(),
            'rapat' => $rapat,
            'qrCode' => $qrCode,
            'notulis' => $notulis,
            'disahkan' => $disahkan
        ];
        $pdf = PDF::loadView('template.pdf-notula-rapat', $data);
        $pdf->setPaper('Folio', 'potrait');
        return $pdf->stream('Notula ' . $rapat->perihal . ' ' . $rapat->detailRapat->tanggal_rapat . '.pdf');
    }

    public function printDokumentasiRapat(Request $request)
    {

    }


}
