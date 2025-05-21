<?php

namespace App\Http\Controllers\Manajemen;

use Carbon\Carbon;
use App\Helpers\TimeSession;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
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
    public function printUndanganPengawasan(Request $request)
    {
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));

        if ($rapat->pejabat_pengganti_id) {
            $pengganti = PejabatPenggantiModel::findOrFail($rapat->pejabat_pengganti_id);
            $pejabatPengganti = $pengganti->pejabat;
        } else {
            $pejabatPengganti = null;
        }
        // Generate QR code
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
    public function printDaftarHadirPengawasan(Request $request)
    {
        $peserta = $request->jumlahPeserta;
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));
        // Generate QR code
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

    public function printNotulaPengawasan(Request $request)
    {
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));
        // Generate QR code
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

    public function printDokumentasiPengawasan(Request $request)
    {
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));
        $dokumentasi = DokumentasiRapatModel::with('detailRapat')->where('detail_rapat_id', '=', $rapat->detailRapat->id)->get();

        // Generate QR code
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
        $qrCode = base64_encode(QrCode::format('png')->size(60)->generate($url));
        $aplikasi = AplikasiModel::first();
        $kotaSurat = explode("/", $aplikasi->kota)[0];
        $data = [
            'aplikasi' => AplikasiModel::first(),
            'rapat' => $rapat,
            'pengawasan' => $temuan,
            'qrCode' => $qrCode,
            'title' => $pengawasan->first(),
            'periode' => $setPeriode,
            'kotaSurat' => $kotaSurat,
            'url' => $url
        ];

        return Pdf::view('template.pdf-laporan-pengawasan', $data)
            ->paperSize('220', '330', 'mm')->margins('10', '10', '10', '10')->portrait();

    }

    public function printKunjunganPengawasan(Request $request)
    {
        // Search kunjungan on database
        $detailKunjungan = DetailKunjunganModel::with('hakimPengawas')->findOrFail(Crypt::decrypt($request->id));
        $kunjungan = KunjunganPengawasanModel::with('unitKerja')->findOrFail($detailKunjungan->kunjungan_pengawasan_id);

        $hakim = PegawaiModel::findOrFail($detailKunjungan->hakimPengawas->pegawai_id);

        $data = [
            'aplikasi' => AplikasiModel::first(),
            'kunjungan' => $kunjungan,
            'detailKunjungan' => $detailKunjungan,
            'title' => $kunjungan->unitKerja->unit_kerja,
            'hakim' => $hakim
        ];

        return Pdf::view('template.pdf-kunjungan-wasbid', $data)
            ->paperSize('220', '330', 'mm')->margins('10', '10', '10', '10')->portrait();
    }
}
