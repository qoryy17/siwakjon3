<?php

namespace App\Http\Controllers\Manajemen;

use PDF;
use Carbon\Carbon;
use App\Helpers\TimeSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manajemen\DetailKunjunganModel;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Support\Facades\Crypt;
use App\Models\Pengaturan\AplikasiModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Manajemen\ManajemenRapatModel;
use App\Models\Pengguna\PejabatPenggantiModel;
use App\Models\Manajemen\DokumentasiRapatModel;
use App\Models\Manajemen\KunjunganPengawasanModel;
use App\Models\Manajemen\PengawasanBidangModel;

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
        $data = [
            'aplikasi' => AplikasiModel::first(),
            'rapat' => $rapat,
            'qrCode' => $qrCode,
            'pegawai' => $pegawai,
            'pejabatPengganti' => $pejabatPengganti
        ];
        $pdf = PDF::loadView('template.pdf-undangan-rapat', $data);
        $pdf->setPaper('Folio', 'potrait');
        return $pdf->stream('Undangan Rapat ' . $rapat->perihal . ' ' . $rapat->detailRapat->tanggal_rapat . '.pdf');
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
            'peserta' => $peserta
        ];
        $pdf = PDF::loadView('template.pdf-daftar-hadir-rapat', $data);
        $pdf->setPaper('Folio', 'potrait');
        return $pdf->stream('Daftar Hadir Rapat ' . $rapat->perihal . ' ' . $rapat->detailRapat->tanggal_rapat . '.pdf');
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
            'disahkan' => $disahkan
        ];
        $pdf = PDF::loadView('template.pdf-notula-rapat', $data);
        $pdf->setPaper('Folio', 'potrait');
        return $pdf->stream('Notula ' . $rapat->perihal . ' ' . $rapat->detailRapat->tanggal_rapat . '.pdf');
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
            'dokumentasi' => $dokumentasi
        ];
        $pdf = PDF::loadView('template.pdf-dokumentasi-rapat', $data);
        $pdf->setPaper('Folio', 'potrait');
        return $pdf->stream('Dokumentasi ' . $rapat->perihal . ' ' . $rapat->detailRapat->tanggal_rapat . '.pdf');

    }

    public function printLaporanPengawasan(Request $request)
    {
        $rapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->findOrFail(Crypt::decrypt($request->id));

        // Search pengawasan on database
        $pengawasan = PengawasanBidangModel::with('temuanWasbid')->where('detail_rapat_id', '=', $rapat->detailRapat->id);
        if (!$pengawasan->exists()) {
            return redirect()->back()->with('error', 'Pengawasan tidak ditemukan !');
        }

        $tanggalRapat = Carbon::parse($rapat->detailRapat->tanggal_rapat);
        $minMonth = 1;
        $newDate = $tanggalRapat->subMonths($minMonth);
        $setPeriode = TimeSession::convertMonthIndonesian($newDate);

        // Generate QR code
        $url = url('/verification') . '/' . $rapat->kode_rapat;
        $qrCode = base64_encode(QrCode::format('png')->size(60)->generate($url));
        $data = [
            'aplikasi' => AplikasiModel::first(),
            'rapat' => $rapat,
            'pengawasan' => $pengawasan->get(),
            'qrCode' => $qrCode,
            'title' => $pengawasan->first(),
            'periode' => $setPeriode
        ];

        $pdf = PDF::loadView('template.pdf-laporan-pengawasan', $data);
        $pdf->setPaper('Folio', 'potrait');
        return $pdf->stream('Laporan Pengawasan Bidang ' . $rapat->detailRapat->tanggal_rapat . '.pdf');
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

        $pdf = PDF::loadView('template.pdf-kunjungan-wasbid', $data);
        $pdf->setPaper('Folio', 'potrait');
        return $pdf->stream('Kunjungan Pengawasan Bidang ' . $kunjungan->unitKerja->unit_kerja . '.pdf');
    }
}
