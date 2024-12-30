<?php

use App\Http\Controllers\Arsip\MonevController;
use App\Http\Controllers\Arsip\SuratKeputusanController;
use App\Http\Controllers\Penggguna\PegawaiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\SigninController;
use App\Http\Controllers\Hakim\HakimPengawasController;
use App\Http\Controllers\Manajemen\KlasifikasiController;
use App\Http\Controllers\Manajemen\KunjunganController;
use App\Http\Controllers\Manajemen\PengawasanController;
use App\Http\Controllers\Manajemen\PrintPengawasanController;
use App\Http\Controllers\Manajemen\PrintRapatController;
use App\Http\Controllers\Manajemen\RapatController;
use App\Http\Controllers\Pengaturan\AplikasiController;
use App\Http\Controllers\Pengaturan\DevelopmentController;
use App\Http\Controllers\Pengaturan\LogsController;
use App\Http\Controllers\Pengaturan\UnitKerjaController;
use App\Http\Controllers\Penggguna\JabatanController;
use App\Http\Controllers\Penggguna\PejabatPenggantiController;
use App\Http\Controllers\Penggguna\PenggunaController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\NonAuthMiddleware;

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::get('/', function () {
        return redirect()->route('signin');
    });
});

Route::middleware(NonAuthMiddleware::class)->group(function () {
    Route::controller(SigninController::class)->group(function () {
        Route::get('/signin', 'index')->name('signin');
    });
});

Route::controller(AuthenticationController::class)->group(function () {
    Route::post('/auth/signin', 'login')->name('auth.signin');
    Route::post('/auth/signout', 'logout')->name('auth.signout');
});


Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/dashboard/superadmin', 'berandaSuperadmin')->name('home.superadmin');
        Route::get('/dashboard/administrator', 'berandaAdmin')->name('home.administrator');
        Route::get('/dashboard/user', 'berandaUser')->name('home.user');
        Route::get('/dashboard/version', 'version')->name('home.version');
        Route::get('/dashboard/logs', 'logs')->name('home.logs');
        Route::get('/dashboard/rapat', 'pintasanRapat')->name('home.pintasan-rapat');
        Route::get('/dashboard/rapat-pengawasan', 'pintasanPengawasan')->name('home.pintasan-pengawasan');
        Route::get('/dashboard/notifikasi', 'notifikasi')->name('home.notifikasi');
        Route::get('/dashboard/profil', 'profil')->name('home.profil');
        Route::post('/dashboard/profil/simpan', 'saveProfil')->name('home.simpan-profil');

        Route::post('/dashboard/ganti-password', 'gantiPassword')->name('home.ganti-password');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(RapatController::class)->group(function () {
        Route::get('/manajemen-rapat/rapat-dinas', 'indexRapat')->name('rapat.index');
        Route::get('/manajemen-rapat/rapat-dinas/detail/{id}', 'detailRapat')->name('rapat.detail');
        Route::get('/manajemen-rapat/rapat-dinas/form/{param}/{id}', 'formUndangan')->name('rapat.form-undangan');
        Route::get('/manajemen-rapat/rapat-dinas/notula/{id}', 'formNotula')->name('rapat.form-notula');
        Route::get('/manajemen-rapat/rapat-dinas/dokumentasi/{id}', 'formDokumentasi')->name('rapat.form-dokumentasi');

        Route::post('/manajemen-rapat/rapat-dinas/simpan', 'saveRapat')->name('rapat.simpan-rapat');
        Route::delete('/manajemen-rapat/rapat-dinas/hapus', 'deleteRapat')->name('rapat.hapus-rapat');
        Route::post('/manajemen-rapat/rapat-dinas/notula/simpan', 'saveNotula')->name('rapat.simpan-notula');
        Route::post('/manajemen-rapat/rapat-dinas/dokumentasi/simpan', 'saveDokumentasi')->name('rapat.simpan-dokumentasi');
        Route::delete('/manajemen-rapat/rapat-dinas/dokumentasi/hapus', 'deleteDokumentasi')->name('rapat.hapus-dokumentasi');

        Route::post('/manajemen-rapat/rapat-dinas/edoc/simpan', 'saveEdoc')->name('rapat.simpan-edoc');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(PrintRapatController::class)->group(function () {
        Route::get('/manajemen-rapat/print/undangan/{id}', 'printUndanganRapat')->name('rapat.print-undangan');
        Route::get('/manajemen-rapat/print/daftar-hadir/{id}', 'printDaftarHadirRapat')->name('rapat.print-daftar-hadir');
        Route::get('/manajemen-rapat/print/notula/{id}', 'printNotulaRapat')->name('rapat.print-notula');
        Route::get('/manajemen-rapat/print/dokumentasi/{id}', 'printDokumentasiRapat')->name('rapat.print-dokumentasi');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(PengawasanController::class)->group(function () {
        Route::get('/pengawasan-bidang/rapat-pengawasan', 'indexPengawasan')->name('pengawasan.index');
        Route::get('/pengawasan-bidang/rapat-pengawasan/detail/{id}', 'detailPengawasan')->name('pengawasan.detail');
        Route::get('/pengawasan-bidang/rapat-pengawasan/form/{param}/{id}', 'formUndangan')->name('pengawasan.form-undangan');
        Route::get('/pengawasan-bidang/rapat-pengawasan/notula/{id}', 'formNotula')->name('pengawasan.form-notula');
        Route::get('/pengawasan-bidang/rapat-pengawasan/dokumentasi/{id}', 'formDokumentasi')->name('pengawasan.form-dokumentasi');

        Route::post('/pengawasan-bidang/rapat-pengawasan/simpan', 'savePengawasan')->name('pengawasan.simpan-rapat');
        Route::delete('/pengawasan-bidang/rapat-pengawasan/hapus', 'deletePengawasan')->name('pengawasan.hapus-rapat');
        Route::post('/pengawasan-bidang/rapat-pengawasan/notula/simpan', 'saveNotula')->name('pengawasan.simpan-notula');
        Route::post('/pengawasan-bidang/rapat-pengawasan/dokumentasi/simpan', 'saveDokumentasi')->name('pengawasan.simpan-dokumentasi');
        Route::delete('/pengawasan-bidang/rapat-pengawasan/dokumentasi/hapus', 'deleteDokumentasi')->name('pengawasan.hapus-dokumentasi');

        // Handle for laporan dan temuan
        Route::get('/pengawasan-bidang/laporan/{id}', 'laporanPengawasan')->name('pengawasan.laporan');
        Route::post('/pengawasan-bidang/laporan/simpan', 'saveLaporan')->name('pengawasan.simpan-laporan');
        Route::post('/pengawasan-bidang/rapat-pengawasan/temuan/simpan', 'saveTemuan')->name('pengawasan.simpan-temuan');
        Route::delete('/pengawasan-bidang/rapat-pengawasan/temuan/hapus', 'deleteTemuan')->name('pengawasan.hapus-temuan');

        Route::post('/pengawasan-bidang/rapat-pengawasan/edoc/simpan', 'saveEdoc')->name('pengawasan.simpan-edoc');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(KunjunganController::class)->group(function () {
        Route::get('/pengawasan-bidang/kunjungan-pengawasan', 'indexKunjungan')->name('kunjungan.index');
        Route::get('/pengawasan-bidang/rapat-pengawasan/form-kunjungan/{param}/{id}', 'formKunjungan')->name('kunjungan.form-kunjungan');
        Route::get('/pengawasan-bidang/kunjungan-pengawasan/detail/{id}', 'detailKunjungan')->name('kunjungan.detail');
        Route::post('/pengawasan-bidang/kunjungan-pengawasan/simpan', 'saveKunjungan')->name('kunjungan.simpan-kunjungan');
        Route::delete('/pengawasan-bidang/kunjungan-pengawasan/hapus', 'deleteKunjungan')->name('kunjungan.hapus-kunjungan');

        Route::get('/pengawasan-bidang/rapat-pengawasan/form-agenda/{param}/{id}', 'formAgenda')->name('kunjungan.form-agenda');
        Route::post('/pengawasan-bidang/kunjungan-pengawasan/agenda/simpan', 'saveAgenda')->name('kunjungan.simpan-agenda');
        Route::delete('/pengawasan-bidang/kunjungan-pengawasan/agenda/hapus', 'deleteAgenda')->name('kunjungan.hapus-agenda');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(PrintPengawasanController::class)->group(function () {
        Route::get('/pengawasan-bidang/print/undangan/{id}', 'printUndanganPengawasan')->name('pengawasan.print-undangan');
        Route::get('/pengawasan-bidang/print/daftar-hadir/{id}', 'printDaftarHadirPengawasan')->name('pengawasan.print-daftar-hadir');
        Route::get('/pengawasan-bidang/print/notula/{id}', 'printNotulaPengawasan')->name('pengawasan.print-notula');
        Route::get('/pengawasan-bidang/print/dokumentasi/{id}', 'printDokumentasiPengawasan')->name('pengawasan.print-dokumentasi');
        Route::get('/pengawasan-bidang/print/laporan/{id}', 'printLaporanPengawasan')->name('pengawasan.print-laporan');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(HakimPengawasController::class)->group(function () {
        Route::get('/pengawasan-bidang/daftar-hakim-pengawas', 'indexDaftarHakim')->name('pengawasan.daftar-hakim-pengawas');

        Route::get('/manajemen-pengguna/hakim-pengawas/form/{param}/{id}', 'formHakimPengawas')->name('pengguna.form-hakim-pengawas');
        Route::get('/manajemen-pengguna/hakim-pengawas', 'indexHakimPengawas')->name('pengguna.hakim-pengawas');
        Route::post('/manajemen-pengguna/simpan-hakim-pengawas', 'save')->name('pengguna.simpan-hakim-pengawas');
        Route::delete('/manajemen-pengguna/hapus-hakim-pengawas', 'delete')->name('pengguna.hapus-hakim-pengawas');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(MonevController::class)->group(function () {
        Route::get('/manajemen-monev/laporan-monev', 'indexMonev')->name('monev.index');
        Route::get('/manajemen-monev/laporan-monev/agenda/form/{param}/{id}', 'formAgendaMonev')->name('monev.formAgendaMonev');
        Route::get('/manajemen-monev/laporan-monev/agenda/detail/{id}', 'detailAgendaMonev')->name('monev.detailAgendaMonev');
        Route::post('/manajemen-monev/simpan-agenda-monev', 'saveAgendaMonev')->name('monev.simpan-agenda');
        Route::delete('/manajemen-monev/hapus-agenda-monev', 'deleteAgendaMonev')->name('monev.hapus-agenda');

        // Save and delete Monev
        Route::post('/manajemen-monev/simpan-monev', 'saveMonev')->name('monev.simpan-monev');
        Route::post('/manajemen-monev/perbarui-monev', 'updateMonev')->name('monev.perbarui-monev');
        Route::delete('/manajemen-monev/hapus-monev', 'deleteMonev')->name('monev.hapus-monev');
        Route::post('/manajemen-monev/unggah-monev', 'unggahMonev')->name('monev.unggah-monev');

        Route::get('/manajemen-monev/periode-monev', 'indexPeriodeMonev')->name('monev.periode');
        Route::get('/manajemen-monev/periode-monev/form/{param}/{id}', 'formPeriodeMonev')->name('monev.formPeriode');
        Route::post('/manajemen-monev/simpan-periode-monev', 'savePeriodeMonev')->name('monev.simpan-periode');
        Route::delete('/manajemen-monev/hapus-periode-monev', 'deletePeriodeMonev')->name('monev.hapus-periode');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(SuratKeputusanController::class)->group(function () {
        Route::get('/manajemen-arsip/surat-keputusan', 'indexArsipSK')->name('arsip.surat-keputusan');
        Route::get('/manajemen-arsip/surat-keputusan/form/{param}/{id}', 'formArsipSK')->name('arsip.form-sk');
        Route::post('/manajemen-arsip/simpan-sk', 'save')->name('arsip.simpan-sk');
        Route::delete('/manajemen-arsip/hapus-sk', 'delete')->name('arsip.hapus-sk');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(PenggunaController::class)->group(function () {
        Route::get('/manajemen-pengguna/akun-pengguna', 'indexAkunPengguna')->name('pengguna.akun');
        Route::get('/manajemen-pengguna/akun-pengguna/form/{param}/{id}', 'formAkunPengguna')->name('pengguna.form-akun');
        Route::post('/manajamen-pengguna/simpan-pengguna', 'savePengguna')->name('pengguna.simpan-akun');
        Route::delete('/manajemen-pengguna/hapus-pengguna', 'deletePengguna')->name('pengguna.hapus-akun');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(PegawaiController::class)->group(function () {
        Route::get('/manajemen-pengguna/pegawai', 'indexPegawai')->name('pengguna.pegawai');
        Route::get('/manajemen-pengguna/pegawai/form/{param}/{id}', 'formPegawai')->name('pengguna.form-pegawai');
        Route::post('/manajamen-pengguna/simpan-pegawai', 'savePegawai')->name('pengguna.simpan-pegawai');
        Route::delete('/manajemen-pengguna/hapus-pegawai', 'deletePegawai')->name('pengguna.hapus-pegawai');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(JabatanController::class)->group(function () {
        Route::get('/manajemen-pengaturan/jabatan', 'indexJabatan')->name('jabatan.index');
        Route::get('/manajemen-pengaturan/jabatan/form/{param}/{id}', 'formJabatan')->name('jabatan.form');
        Route::post('/manajemen-pengaturan/simpan-jabatan', 'save')->name('jabatan.simpan');
        Route::delete('/manajemen-pengaturan/hapus-jabatan', 'delete')->name('jabatan.hapus');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(UnitKerjaController::class)->group(function () {
        Route::get('/manajemen-pengaturan/unit-kerja', 'indexUnitKerja')->name('unitKerja.index');
        Route::get('/manajemen-pengaturan/unit-kerja/form/{param}/{id}', 'formUnitKerja')->name('unitKerja.form');
        Route::post('/manajemen-pengaturan/simpan-unit-kerja', 'save')->name('unitKerja.simpan');
        Route::delete('/manajemen-pengaturan/hapus-unit-kerja', 'delete')->name('unitKerja.hapus');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(PejabatPenggantiController::class)->group(function () {
        Route::get('/manajemen-pengaturan/pejabat-pengganti', 'indexPejabatPengganti')->name('pejabatPengganti.index');
        Route::get('/manajemen-pengaturan/pejabat-pengganti/form/{param}/{id}', 'formPejabatPengganti')->name('pejabatPengganti.form');
        Route::post('/manajemen-pengaturan/simpan-pejabat-pengganti', 'save')->name('pejabatPengganti.simpan');
        Route::delete('/manajemen-pengaturan/hapus-pejabat-pengganti', 'delete')->name('pejabatPengganti.hapus');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(KlasifikasiController::class)->group(function () {
        Route::get('/manajemen-pengaturan/klasifikasi/{param}', 'indexKlasifikasi')->name('klasifikasi.index');
        Route::get('/manajemen-pengaturan/klasifikasi/{klaster}/form/{param}/{id}', 'formKlasifikasi')->name('klasifikasi.form');

        // For klasifikasi rapat
        Route::post('/manajemen-pengaturan/klasifikasi/simpan-rapat', 'saveKlasifikasiRapat')->name('klasifikasi.simpan-rapat');
        Route::delete('/manajemen-pengaturan/klasifikasi/hapus-rapat', 'deleteKlasifikasiRapat')->name('klasifikasi.hapus-rapat');

        // For klasifikasi surat
        Route::post('/manajemen-pengaturan/klasifikasi/simpan-surat', 'saveKlasifikasiSurat')->name('klasifikasi.simpan-surat');
        Route::delete('/manajemen-pengaturan/klasifikasi/hapus-surat', 'deleteKlasifikasiSurat')->name('klasifikasi.hapus-surat');

        // For klasifikasi jabatan
        Route::post('/manajemen-pengaturan/klasifikasi/simpan-jabatan', 'saveKlasifikasiJabatan')->name('klasifikasi.simpan-jabatan');
        Route::delete('/manajemen-pengaturan/klasifikasi/hapus-jabatan', 'deleteKlasifikasiJabatan')->name('klasifikasi.hapus-jabatan');

        Route::get('/manajemen-pengaturan/set-kode-rapat/', 'indexSetKode')->name('klasifikasi.set-kode');
        Route::post('/manajemen-pengaturan/simpan-kode-rapat', 'saveKodeRapat')->name('klasifikasi.simpan-kode');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(AplikasiController::class)->group(function () {
        Route::get('/pengaturan-aplikasi/konfigurasi', 'indexKonfigurasi')->name('aplikasi.konfigurasi');
        Route::post('/pengaturan-aplikasi/simpan', 'save')->name('aplikasi.simpan-konfigurasi');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(DevelopmentController::class)->group(function () {
        Route::get('/pengaturan-aplikasi/catatan-pengembang', 'indexCatatanPengembang')->name('aplikasi.pengembang');
        Route::get('/pengaturan-aplikasi/catatan-pengembang/form/{param}/{id}', 'formCatatanPengembang')->name('aplikasi.form-pengembang');
        Route::post('/pengaturan-aplikasi/simpan-catatan', 'saveCatatanPengembang')->name('aplikasi.simpan-pengembang');
        Route::delete('/pengaturan-aplikasi/hapus-catatan', 'deleteCatatanPengembang')->name('aplikasi.hapus-pengembang');

        Route::get('/pengaturan-aplikasi/version', 'indexVersion')->name('aplikasi.version');
        Route::get('/pengaturan-aplikasi/version/form/{param}/{id}', 'formVersion')->name('aplikasi.form-version');
        Route::post('/pengaturan-aplikasi/simpan-version', 'saveVersion')->name(name: 'aplikasi.simpan-version');
        Route::delete('/pengaturan-aplikasi/hapus-version', 'deleteVersion')->name('aplikasi.hapus-version');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(LogsController::class)->group(function () {
        Route::get('/pengaturan-aplikasi/logs', 'indexLogs')->name('aplikasi.logs');
        Route::post('/pengaturan-aplikasi/logs/hapus', 'deleteLogs')->name('aplikasi.logs-hapus');
    });
});
