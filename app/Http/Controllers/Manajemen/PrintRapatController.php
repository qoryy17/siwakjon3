<?php

namespace App\Http\Controllers\Manajemen;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
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
    protected $aplikasi;
    public function __construct()
    {
        $this->aplikasi = cache()->remember('aplikasi_data', 60 * 60, function () {
            return AplikasiModel::first();
        });
    }
    protected function genereteQrCode($url)
    {
        $qrCode = QrCode::format('png')
            ->size(60)
            ->generate($url);

        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrCode);
        return $qrCodeBase64;
    }
    public function printUndanganRapat(Request $request)
    {
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));

        $pejabatPengganti = null;
        if (!empty($rapat->pejabat_pengganti_id)) {
            $pengganti = PejabatPenggantiModel::find($rapat->pejabat_pengganti_id);
            $pejabatPengganti = $pengganti ? $pengganti->pejabat : null;
        }
        $pegawai = PegawaiModel::with('jabatan')->findOrFail($rapat->pejabat_penandatangan);

        // Generate QR code
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = $this->genereteQrCode($url);
        $aplikasi = $this->aplikasi;

        $kotaSurat = explode("/", $aplikasi->kota)[0];
        $kabSurat = explode("/", $aplikasi->kota)[1];
        $data = [
            'aplikasi' => $aplikasi,
            'rapat' => $rapat,
            'qrCode' => $qrCode,
            'pegawai' => $pegawai,
            'kotaSurat' => $kotaSurat,
            'pejabatPengganti' => $pejabatPengganti,
            'url' => $url,
            'kabSurat' => $kabSurat
        ];

        $pdf = Pdf::loadView('template.pdf-undangan-rapat', $data)->setPaper('folio', 'potrait')->setOptions(['isRemoteEnabled' => true]);
        return $pdf->stream();
    }
    public function printDaftarHadirRapat(Request $request)
    {
        $peserta = $request->jumlahPeserta;
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));
        // Generate QR code
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = $this->genereteQrCode($url);
        $aplikasi = $this->aplikasi;

        $kabSurat = explode("/", $aplikasi->kota)[1];
        $data = [
            'aplikasi' => $aplikasi,
            'rapat' => $rapat,
            'qrCode' => $qrCode,
            'peserta' => $peserta,
            'url' => $url,
            'kabSurat' => $kabSurat
        ];
        $pdf = Pdf::loadView('template.pdf-daftar-hadir-rapat', $data)->setPaper('folio', 'potrait')->setOptions(['isRemoteEnabled' => true]);
        return $pdf->stream();
    }

    public function printNotulaRapat(Request $request)
    {
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));
        // Generate QR code
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = $this->genereteQrCode($url);
        $aplikasi = $this->aplikasi;

        $notulis = PegawaiModel::findOrFail($rapat->detailRapat->notulen);
        $disahkan = PegawaiModel::findOrFail($rapat->detailRapat->disahkan);
        $kabSurat = explode("/", $aplikasi->kota)[1];
        $data = [
            'aplikasi' => $aplikasi,
            'rapat' => $rapat,
            'qrCode' => $qrCode,
            'notulis' => $notulis,
            'disahkan' => $disahkan,
            'url' => $url,
            'kabSurat' => $kabSurat
        ];
        $pdf = Pdf::loadView('template.pdf-notula-rapat', $data)->setPaper('folio', 'potrait')->setOptions(['isRemoteEnabled' => true]);
        return $pdf->stream();
    }

    public function printDokumentasiRapat(Request $request)
    {
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));
        $dokumentasi = DokumentasiRapatModel::with('detailRapat')->where('detail_rapat_id', '=', $rapat->detailRapat->id)->get();
        // Generate QR code
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = $this->genereteQrCode($url);
        $aplikasi = $this->aplikasi;

        $kabSurat = explode("/", $aplikasi->kota)[1];
        $data = [
            'aplikasi' => $aplikasi,
            'rapat' => $rapat,
            'qrCode' => $qrCode,
            'dokumentasi' => $dokumentasi,
            'url' => $url,
            'kabSurat' => $kabSurat
        ];
        $pdf = Pdf::loadView('template.pdf-dokumentasi-rapat', $data)->setPaper('folio', 'potrait')->setOptions(['isRemoteEnabled' => true]);
        return $pdf->stream();
    }
}
