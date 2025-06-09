<?php

namespace App\Http\Controllers\Manajemen;

use Carbon\Carbon;
use App\Helpers\TimeSession;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Support\Facades\Crypt;
use App\Models\Pengaturan\AplikasiModel;
use App\Models\Manajemen\TemuanWasbidModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Manajemen\ManajemenRapatModel;
use App\Models\Manajemen\DetailKunjunganModel;
use App\Models\Pengguna\PejabatPenggantiModel;
use App\Models\Manajemen\DokumentasiRapatModel;
use App\Models\Manajemen\PengawasanBidangModel;
use App\Models\Manajemen\KunjunganPengawasanModel;

class PrintPengawasanController extends Controller
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
    public function printUndanganPengawasan(Request $request)
    {
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));

        $pejabatPengganti = null;
        if (!empty($rapat->pejabat_pengganti_id)) {
            $pengganti = PejabatPenggantiModel::find($rapat->pejabat_pengganti_id);
            $pejabatPengganti = $pengganti ? $pengganti->pejabat : null;
        }
        // Generate QR code
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = $this->genereteQrCode($url);
        $aplikasi = $this->aplikasi;

        $pegawai = PegawaiModel::with('jabatan')->findOrFail($rapat->pejabat_penandatangan);

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
    public function printDaftarHadirPengawasan(Request $request)
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
            'url' => $url
        ];

        $pdf = Pdf::loadView('template.pdf-daftar-hadir-rapat', $data)->setPaper('folio', 'potrait')->setOptions(['isRemoteEnabled' => true]);
        return $pdf->stream();
    }

    public function printNotulaPengawasan(Request $request)
    {
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));
        // Generate QR code
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = $this->genereteQrCode($url);
        $aplikasi = $this->aplikasi;

        $notulis = PegawaiModel::findOrFail($rapat->detailRapat->notulen);
        $disahkan = PegawaiModel::findOrFail($rapat->detailRapat->disahkan);
        $aplikasi = AplikasiModel::first();
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

    public function printDokumentasiPengawasan(Request $request)
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
            'kabSurat' => $kabSurat,
        ];

        $pdf = Pdf::loadView('template.pdf-dokumentasi-rapat', $data)->setPaper('folio', 'potrait')->setOptions(['isRemoteEnabled' => true]);
        return $pdf->stream();
    }

    public function printLaporanPengawasan(Request $request)
    {
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));

        // Search pengawasan on database
        $pengawasan = PengawasanBidangModel::with('temuanWasbid')->where('detail_rapat_id', '=', $rapat->detailRapat->id);
        if (!$pengawasan->exists()) {
            return redirect()->back()->with('error', 'Pengawasan tidak ditemukan !');
        }

        $temuan = TemuanWasbidModel::where('pengawasan_bidang_id', '=', $pengawasan->first()->id)->orderBy('created_at', 'asc')->get();

        $tanggalRapat = Carbon::parse($rapat->detailRapat->tanggal_rapat);
        $minMonth = 1;
        $newDate = $tanggalRapat->subMonths($minMonth);
        $setPeriode = TimeSession::convertMonthIndonesian($newDate);

        // Generate QR code
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = $this->genereteQrCode($url);
        $aplikasi = $this->aplikasi;

        $kotaSurat = explode("/", $aplikasi->kota)[0];
        $data = [
            'aplikasi' => $aplikasi,
            'rapat' => $rapat,
            'pengawasan' => $temuan,
            'qrCode' => $qrCode,
            'title' => $pengawasan->first(),
            'periode' => $setPeriode,
            'kotaSurat' => $kotaSurat,
            'url' => $url
        ];

        $pdf = Pdf::loadView('template.pdf-laporan-pengawasan', $data)->setPaper('folio', 'potrait')->setOptions(['isRemoteEnabled' => true]);
        return $pdf->stream();
    }

    public function printKunjunganPengawasan(Request $request)
    {
        // Search kunjungan on database
        $detailKunjungan = DetailKunjunganModel::with('hakimPengawas')->findOrFail(Crypt::decrypt($request->id));
        $kunjungan = KunjunganPengawasanModel::with('unitKerja')->findOrFail($detailKunjungan->kunjungan_pengawasan_id);

        $hakim = PegawaiModel::findOrFail($detailKunjungan->hakimPengawas->pegawai_id);
        $aplikasi = $this->aplikasi;
        $kabSurat = explode("/", $aplikasi->kota)[1];
        $data = [
            'aplikasi' => $aplikasi,
            'kunjungan' => $kunjungan,
            'detailKunjungan' => $detailKunjungan,
            'title' => $kunjungan->unitKerja->unit_kerja,
            'hakim' => $hakim,
            'kabSurat' => $kabSurat,
        ];

        $pdf = Pdf::loadView('template.pdf-kunjungan-wasbid', $data)->setPaper('folio', 'potrait')->setOptions(['isRemoteEnabled' => true]);
        return $pdf->stream();
    }
}
