<?php

namespace App\Http\Controllers\Manajemen;

use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Support\Facades\Crypt;
use App\Models\Pengaturan\AplikasiModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Manajemen\ManajemenRapatModel;
use App\Models\Pengguna\PejabatPenggantiModel;
use App\Models\Manajemen\DokumentasiRapatModel;

class PrintRapatController extends Controller
{
    public function printUndanganRapat(Request $request)
    {
        // Generate QR code
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));

        if ($rapat->pejabat_pengganti_id) {
            $pengganti = PejabatPenggantiModel::findOrFail($rapat->pejabat_pengganti_id);
            $pejabatPengganti = $pengganti->pejabat;
        } else {
            $pejabatPengganti = null;
        }
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = base64_encode(QrCode::format('png')->size(60)->generate($url));
        $pegawai = PegawaiModel::with('jabatan')->findOrFail($rapat->pejabat_penandatangan);

        $aplikasi = AplikasiModel::first();
        $kotaSurat = explode("/", $aplikasi->kota)[0];
        $data = [
            'aplikasi' => AplikasiModel::first(),
            'rapat' => $rapat,
            'qrCode' => $qrCode,
            'pegawai' => $pegawai,
            'kotaSurat' => $kotaSurat,
            'pejabatPengganti' => $pejabatPengganti,
            'url' => $url
        ];
        return Pdf::view('template.pdf-undangan-rapat', $data)
            ->paperSize('220', '330', 'mm')->margins('10', '10', '10', '10')->portrait();
    }
    public function printDaftarHadirRapat(Request $request)
    {
        $peserta = $request->jumlahPeserta;
        // Generate QR code
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = base64_encode(QrCode::format('png')->size(60)->generate($url));
        $data = [
            'aplikasi' => AplikasiModel::first(),
            'rapat' => $rapat,
            'qrCode' => $qrCode,
            'peserta' => $peserta,
            'url' => $url
        ];
        return Pdf::view('template.pdf-daftar-hadir-rapat', $data)
            ->paperSize('220', '330', 'mm')->margins('10', '10', '10', '10')->portrait();
    }

    public function printNotulaRapat(Request $request)
    {
        // Generate QR code
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = base64_encode(QrCode::format('png')->size(60)->generate($url));

        $notulis = PegawaiModel::findOrFail($rapat->detailRapat->notulen);
        $disahkan = PegawaiModel::findOrFail($rapat->detailRapat->disahkan);
        $data = [
            'aplikasi' => AplikasiModel::first(),
            'rapat' => $rapat,
            'qrCode' => $qrCode,
            'notulis' => $notulis,
            'disahkan' => $disahkan,
            'url' => $url
        ];
        return Pdf::view('template.pdf-notula-rapat', $data)
            ->paperSize('220', '330', 'mm')->margins('10', '10', '10', '10')->portrait();
    }

    public function printDokumentasiRapat(Request $request)
    {
        // Generate QR code
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));
        $dokumentasi = DokumentasiRapatModel::with('detailRapat')->where('detail_rapat_id', '=', $rapat->detailRapat->id)->get();

        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = base64_encode(QrCode::format('png')->size(60)->generate($url));
        $data = [
            'aplikasi' => AplikasiModel::first(),
            'rapat' => $rapat,
            'qrCode' => $qrCode,
            'dokumentasi' => $dokumentasi,
            'url' => $url
        ];
        return Pdf::view('template.pdf-dokumentasi-rapat', $data)
            ->paperSize('220', '330', 'mm')->margins('10', '10', '10', '10')->portrait();
    }
}
