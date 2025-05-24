<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\NonAuthMiddleware;
use App\Http\Controllers\LicenseController;
use App\Http\Middleware\RejectUserMiddleware;
use App\Http\Middleware\SuperadminMiddleware;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\Arsip\MonevController;
use App\Http\Controllers\Auth\SigninController;
use App\Http\Controllers\VerificationController;
use App\Http\Middleware\RejectNonHakimMiddleware;
use App\Http\Middleware\License\LicenseMiddleware;
use App\Http\Controllers\Manajemen\RapatController;
use App\Http\Controllers\Pengaturan\LogsController;
use App\Http\Controllers\Penggguna\JabatanController;
use App\Http\Controllers\Penggguna\PegawaiController;
use App\Http\Controllers\Penggguna\PenggunaController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Hakim\HakimPengawasController;
use App\Http\Controllers\Manajemen\KunjunganController;
use App\Http\Controllers\Pengaturan\AplikasiController;
use App\Http\Controllers\Arsip\SuratKeputusanController;
use App\Http\Controllers\Manajemen\PengawasanController;
use App\Http\Controllers\Manajemen\PrintRapatController;
use App\Http\Controllers\Pengaturan\UnitKerjaController;
use App\Http\Controllers\Manajemen\KlasifikasiController;
use App\Http\Controllers\Pengaturan\DevelopmentController;
use App\Http\Controllers\Manajemen\PrintPengawasanController;
use App\Http\Controllers\Penggguna\PejabatPenggantiController;
use App\Http\Controllers\Manajemen\MonitoringPengawasanController;

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::get('/', function () {
        return redirect()->route('signin');
    });
});

Route::controller(VerificationController::class)->group(function () {
    Route::get('/verification/{search?}', 'index')->name('verification');
});

Route::middleware([NonAuthMiddleware::class, LicenseMiddleware::class])
    ->controller(SigninController::class)->group(function () {
        Route::get('/signin', 'index')->name('signin');
    });

Route::prefix('auth')->middleware(LicenseMiddleware::class)
    ->controller(AuthenticationController::class)->group(function () {
        Route::post('/signin', 'login')->name('auth.signin');
        Route::post('/signout', 'logout')->name('auth.signout');
    });

Route::prefix('app')->controller(LicenseController::class)->group(function () {
    Route::get('/license', 'index')->name('license.index');
    Route::post('/license/save', 'saveLicense')->name('license.save');
});

Route::prefix('dashboard')->middleware([AuthMiddleware::class, LicenseMiddleware::class])
    ->controller(HomeController::class)->group(function () {
        Route::get('/superadmin', 'berandaSuperadmin')->name('home.superadmin');
        Route::get('/administrator', 'berandaAdmin')->name('home.administrator');
        Route::get('/user', 'berandaUser')->name('home.user');
        Route::get('/version', 'version')->name('home.version');
        Route::get('/logs', 'logs')->name('home.logs');
        Route::get('/rapat', 'pintasanRapat')->name('home.pintasan-rapat');
        Route::get('/rapat-pengawasan', 'pintasanPengawasan')->name('home.pintasan-pengawasan');
        Route::get('/notifikasi', 'notifikasi')->name('home.notifikasi');
        Route::get('/profil', 'profil')->name('home.profil');
        Route::post('/profil/simpan', 'saveProfil')->name('home.simpan-profil');

        Route::post('/ganti-password', 'gantiPassword')->name('home.ganti-password');
    });

Route::prefix('manajemen-rapat/rapat-dinas')->middleware([AuthMiddleware::class, LicenseMiddleware::class])
    ->controller(RapatController::class)->group(function () {
        Route::get('/', 'indexRapat')->name('rapat.index');
        Route::get('/detail/{id}', 'detailRapat')->name('rapat.detail');
        Route::get('/form/{param}/{id}', 'formUndangan')->name('rapat.form-undangan');
        Route::get('/notula/{id}', 'formNotula')->name('rapat.form-notula');
        Route::get('/dokumentasi/{id}', 'formDokumentasi')->name('rapat.form-dokumentasi');

        Route::post('/simpan', 'saveRapat')->name('rapat.simpan-rapat');
        Route::delete('/hapus', 'deleteRapat')->name('rapat.hapus-rapat');
        Route::post('/notula/simpan', 'saveNotula')->name('rapat.simpan-notula');
        Route::post('/dokumentasi/simpan', 'saveDokumentasi')->name('rapat.simpan-dokumentasi');
        Route::delete('/dokumentasi/hapus', 'deleteDokumentasi')->name('rapat.hapus-dokumentasi');
        Route::post('/edoc/simpan', 'saveEdoc')->name('rapat.simpan-edoc');

        Route::get('/cari-klasifikasi-rapat', 'searchKlasifikasiRapat')->name('rapat.cari-klasifikasi-rapat');
    });

Route::prefix('manajemen-rapat/print')->middleware([AuthMiddleware::class, LicenseMiddleware::class])
    ->controller(PrintRapatController::class)->group(function () {
        Route::get('/undangan/{id}', 'printUndanganRapat')->name('rapat.print-undangan');
        Route::get('/daftar-hadir/{id}', 'printDaftarHadirRapat')->name('rapat.print-daftar-hadir');
        Route::get('/notula/{id}', 'printNotulaRapat')->name('rapat.print-notula');
        Route::get('/dokumentasi/{id}', 'printDokumentasiRapat')->name('rapat.print-dokumentasi');
    });

Route::prefix('manajemen-pengaturan/set-rapat')->middleware([AuthMiddleware::class, LicenseMiddleware::class, RejectUserMiddleware::class])
    ->controller(RapatController::class)->group(function () {
        // Special for set rapat on manajemen pengaturan, this route is only access for role superadmin and administrator, reject role user
        Route::get('/', 'indexSetRapat')->name('rapat.set-rapat');
        Route::post('/simpan', 'saveSetRapat')->name('rapat.simpan-set-rapat');
    });

Route::prefix('pengawasan-bidang/rapat-pengawasan')->middleware([AuthMiddleware::class, LicenseMiddleware::class, RejectNonHakimMiddleware::class])
    ->controller(PengawasanController::class)->group(function () {
        // Only superadmin, administrator and ketua, wakil ketua, hakim can access this route
        Route::get('/', 'indexPengawasan')->name('pengawasan.index');
        Route::get('/detail/{id}', 'detailPengawasan')->name('pengawasan.detail');
        Route::get('/form/{param}/{id}', 'formUndangan')->name('pengawasan.form-undangan');
        Route::get('/notula/{id}', 'formNotula')->name('pengawasan.form-notula');
        Route::get('/dokumentasi/{id}', 'formDokumentasi')->name('pengawasan.form-dokumentasi');

        Route::post('/simpan', 'savePengawasan')->name('pengawasan.simpan-rapat');
        Route::delete('/hapus', 'deletePengawasan')->name('pengawasan.hapus-rapat');
        Route::post('/notula/simpan', 'saveNotula')->name('pengawasan.simpan-notula');
        Route::post('/dokumentasi/simpan', 'saveDokumentasi')->name('pengawasan.simpan-dokumentasi');
        Route::delete('/dokumentasi/hapus', 'deleteDokumentasi')->name('pengawasan.hapus-dokumentasi');

        // Handle for laporan dan temuan
        Route::get('/laporan/{id}', 'laporanPengawasan')->name('pengawasan.laporan');
        Route::post('/laporan/simpan', 'saveLaporan')->name('pengawasan.simpan-laporan');
        Route::post('/temuan/simpan', 'saveTemuan')->name('pengawasan.simpan-temuan');
        Route::delete('/temuan/hapus', 'deleteTemuan')->name('pengawasan.hapus-temuan');
        Route::post('/edoc/simpan', 'saveEdoc')->name('pengawasan.simpan-edoc');
    });

Route::prefix('pengawasan-bidang')->middleware([AuthMiddleware::class, LicenseMiddleware::class])
    ->controller(MonitoringPengawasanController::class)->group(function () {
        Route::get('/monitoring-pengawasan', 'indexMonitoring')->name('monitoring.index');
    });

Route::prefix('pengawasan-bidang/kunjungan-pengawasan')->middleware([AuthMiddleware::class, LicenseMiddleware::class, RejectNonHakimMiddleware::class])
    ->controller(KunjunganController::class)->group(function () {
        // Only superadmin, administrator and ketua, wakil ketua, hakim can access this route
        Route::get('/', 'indexKunjungan')->name('kunjungan.index');
        Route::get('/rapat-pengawasan/form-kunjungan/{param}/{id}', 'formKunjungan')->name('kunjungan.form-kunjungan');
        Route::get('/detail/{id}', 'detailKunjungan')->name('kunjungan.detail');
        Route::post('/simpan', 'saveKunjungan')->name('kunjungan.simpan-kunjungan');
        Route::delete('/hapus', 'deleteKunjungan')->name('kunjungan.hapus-kunjungan');
        Route::get('/rapat-pengawasan/form-agenda/{param}/{id}', 'formAgenda')->name('kunjungan.form-agenda');
        Route::post('/agenda/simpan', 'saveAgenda')->name('kunjungan.simpan-agenda');
        Route::delete('/agenda/hapus', 'deleteAgenda')->name('kunjungan.hapus-agenda');
        Route::post('/edoc/simpan', 'saveEdoc')->name('kunjungan.simpan-edoc');
    });

Route::prefix('pengawasan-bidang/print')->middleware([AuthMiddleware::class, LicenseMiddleware::class, RejectNonHakimMiddleware::class])
    ->controller(PrintPengawasanController::class)->group(function () {
        // Only superadmin, administrator and hakim can access this route
        Route::get('/undangan/{id}', 'printUndanganPengawasan')->name('pengawasan.print-undangan');
        Route::get('/daftar-hadir/{id}', 'printDaftarHadirPengawasan')->name('pengawasan.print-daftar-hadir');
        Route::get('/notula/{id}', 'printNotulaPengawasan')->name('pengawasan.print-notula');
        Route::get('/dokumentasi/{id}', 'printDokumentasiPengawasan')->name('pengawasan.print-dokumentasi');
        Route::get('/laporan/{id}', 'printLaporanPengawasan')->name('pengawasan.print-laporan');
        Route::get('/kunjungan/{id}', 'printKunjunganPengawasan')->name('kunjungan.print-kunjungan');
    });


Route::middleware([AuthMiddleware::class, LicenseMiddleware::class])
    ->controller(HakimPengawasController::class)->group(function () {
        Route::get('/pengawasan-bidang/daftar-hakim-pengawas', 'indexDaftarHakim')->name('pengawasan.daftar-hakim-pengawas');

        //   Reject role user to access this route
        Route::middleware(RejectUserMiddleware::class)->group(function () {
            Route::get('/manajemen-pengguna/hakim-pengawas/form/{param}/{id}', 'formHakimPengawas')->name('pengguna.form-hakim-pengawas');
            Route::get('/manajemen-pengguna/hakim-pengawas', 'indexHakimPengawas')->name('pengguna.hakim-pengawas');
            Route::post('/manajemen-pengguna/simpan-hakim-pengawas', 'save')->name('pengguna.simpan-hakim-pengawas');
            Route::delete('/manajemen-pengguna/hapus-hakim-pengawas', 'delete')->name('pengguna.hapus-hakim-pengawas');
        });
    });

Route::prefix('manajemen-monev')->middleware([AuthMiddleware::class, LicenseMiddleware::class])
    ->controller(MonevController::class)->group(function () {
        Route::get('/laporan-monev', 'indexMonev')->name('monev.index');
        Route::get('/laporan-monev/agenda/form/{param}/{id}', 'formAgendaMonev')->name('monev.formAgendaMonev');
        Route::get('/laporan-monev/agenda/detail/{id}', 'detailAgendaMonev')->name('monev.detailAgendaMonev');

        //   Reject role user to access this route
        Route::middleware(RejectNonHakimMiddleware::class)->group(function () {
            Route::post('/simpan-agenda-monev', 'saveAgendaMonev')->name('monev.simpan-agenda');
            Route::delete('/hapus-agenda-monev', 'deleteAgendaMonev')->name('monev.hapus-agenda');
        });

        // Save and delete Monev
        Route::post('/simpan-monev', 'saveMonev')->name('monev.simpan-monev');
        Route::post('/perbarui-monev', 'updateMonev')->name('monev.perbarui-monev');
        Route::delete('/hapus-monev', 'deleteMonev')->name('monev.hapus-monev');
        Route::post('/unggah-monev', 'unggahMonev')->name('monev.unggah-monev');

        //   Reject role user to access this route
        Route::middleware(RejectNonHakimMiddleware::class)->group(function () {
            Route::get('/periode-monev', 'indexPeriodeMonev')->name('monev.periode');
            Route::get('/periode-monev/form/{param}/{id}', 'formPeriodeMonev')->name('monev.formPeriode');
            Route::post('/simpan-periode-monev', 'savePeriodeMonev')->name('monev.simpan-periode');
            Route::delete('/hapus-periode-monev', 'deletePeriodeMonev')->name('monev.hapus-periode');
        });
    });

Route::prefix('manajemen-arsip')->middleware([AuthMiddleware::class, LicenseMiddleware::class])
    ->controller(SuratKeputusanController::class)->group(function () {
        Route::get('/surat-keputusan', 'indexArsipSK')->name('arsip.surat-keputusan');

        //   Reject role user to access this route
        Route::middleware(RejectUserMiddleware::class)->group(function () {
            Route::get('/surat-keputusan/form/{param}/{id}', 'formArsipSK')->name('arsip.form-sk');
            Route::post('/simpan-sk', 'save')->name('arsip.simpan-sk');
            Route::delete('/hapus-sk', 'delete')->name('arsip.hapus-sk');
        });
    });

Route::prefix('manajemen-pengguna')->middleware([AuthMiddleware::class, LicenseMiddleware::class, SuperadminMiddleware::class])->group(function () {
    Route::controller(PenggunaController::class)->group(function () {
        // Only superadmin can delete logs
        Route::get('/akun-pengguna', 'indexAkunPengguna')->name('pengguna.akun');
        Route::get('/akun-pengguna/form/{param}/{id}', 'formAkunPengguna')->name('pengguna.form-akun');
        Route::post('/simpan-pengguna', 'savePengguna')->name('pengguna.simpan-akun');
        Route::delete('/hapus-pengguna', 'deletePengguna')->name('pengguna.hapus-akun');
    });

    Route::controller(PegawaiController::class)->group(function () {
        //   Reject role user to access this route
        Route::get('/pegawai', 'indexPegawai')->name('pengguna.pegawai');
        Route::get('/pegawai/form/{param}/{id}', 'formPegawai')->name('pengguna.form-pegawai');
        Route::post('/simpan-pegawai', 'savePegawai')->name('pengguna.simpan-pegawai');
        Route::delete('/hapus-pegawai', 'deletePegawai')->name('pengguna.hapus-pegawai');
    });
});

Route::prefix('manajemen-pengaturan')->middleware([AuthMiddleware::class, LicenseMiddleware::class, RejectUserMiddleware::class])->group(function () {
    Route::controller(JabatanController::class)->group(function () {
        //   Reject role user to access this route
        Route::get('/jabatan', 'indexJabatan')->name('jabatan.index');
        Route::get('/jabatan/form/{param}/{id}', 'formJabatan')->name('jabatan.form');
        Route::post('/simpan-jabatan', 'save')->name('jabatan.simpan');
        Route::delete('/hapus-jabatan', 'delete')->name('jabatan.hapus');
    });

    Route::controller(UnitKerjaController::class)->group(function () {
        Route::get('/unit-kerja', 'indexUnitKerja')->name('unitKerja.index');
        Route::get('/unit-kerja/form/{param}/{id}', 'formUnitKerja')->name('unitKerja.form');
        Route::post('/simpan-unit-kerja', 'save')->name('unitKerja.simpan');
        Route::delete('/hapus-unit-kerja', 'delete')->name('unitKerja.hapus');
    });

    Route::controller(PejabatPenggantiController::class)->group(function () {
        Route::get('/pejabat-pengganti', 'indexPejabatPengganti')->name('pejabatPengganti.index');
        Route::get('/pejabat-pengganti/form/{param}/{id}', 'formPejabatPengganti')->name('pejabatPengganti.form');
        Route::post('/simpan-pejabat-pengganti', 'save')->name('pejabatPengganti.simpan');
        Route::delete('/hapus-pejabat-pengganti', 'delete')->name('pejabatPengganti.hapus');
    });

    Route::controller(KlasifikasiController::class)->group(function () {
        Route::get('/klasifikasi/{param}', 'indexKlasifikasi')->name('klasifikasi.index');
        Route::get('/klasifikasi/{klaster}/form/{param}/{id}', 'formKlasifikasi')->name('klasifikasi.form');

        // For klasifikasi rapat
        Route::post('/klasifikasi/simpan-rapat', 'saveKlasifikasiRapat')->name('klasifikasi.simpan-rapat');
        Route::delete('/klasifikasi/hapus-rapat', 'deleteKlasifikasiRapat')->name('klasifikasi.hapus-rapat');

        // For klasifikasi surat
        Route::post('/klasifikasi/simpan-surat', 'saveKlasifikasiSurat')->name('klasifikasi.simpan-surat');
        Route::delete('/klasifikasi/hapus-surat', 'deleteKlasifikasiSurat')->name('klasifikasi.hapus-surat');

        // For klasifikasi jabatan
        Route::post('/klasifikasi/simpan-jabatan', 'saveKlasifikasiJabatan')->name('klasifikasi.simpan-jabatan');
        Route::delete('/klasifikasi/hapus-jabatan', 'deleteKlasifikasiJabatan')->name('klasifikasi.hapus-jabatan');

        Route::get('/set-kode-rapat', 'indexSetKode')->name('klasifikasi.set-kode');
        Route::post('/simpan-kode-rapat', 'saveKodeRapat')->name('klasifikasi.simpan-kode');
    });

});


Route::prefix('pengaturan-aplikasi')->middleware([AuthMiddleware::class, LicenseMiddleware::class, SuperadminMiddleware::class])
    ->group(function () {
        Route::controller(AplikasiController::class)->group(function () {
            // Only superadmin can access this route
            Route::get('/konfigurasi', 'indexKonfigurasi')->name('aplikasi.konfigurasi');
            Route::post('/simpan', 'save')->name('aplikasi.simpan-konfigurasi');
        });

        Route::controller(DevelopmentController::class)->group(function () {
            Route::get('/catatan-pengembang', 'indexCatatanPengembang')->name('aplikasi.pengembang');
            Route::get('/catatan-pengembang/form/{param}/{id}', 'formCatatanPengembang')->name('aplikasi.form-pengembang');
            Route::post('/simpan-catatan', 'saveCatatanPengembang')->name('aplikasi.simpan-pengembang');
            Route::delete('/hapus-catatan', 'deleteCatatanPengembang')->name('aplikasi.hapus-pengembang');

            Route::get('/version', 'indexVersion')->name('aplikasi.version');
            Route::get('/version/form/{param}/{id}', 'formVersion')->name('aplikasi.form-version');
            Route::post('/simpan-version', 'saveVersion')->name(name: 'aplikasi.simpan-version');
            Route::delete('/hapus-version', 'deleteVersion')->name('aplikasi.hapus-version');
        });
    });

Route::prefix('pengaturan-aplikasi')->middleware([AuthMiddleware::class, LicenseMiddleware::class])->group(function () {
    Route::controller(LogsController::class)->group(function () {
        Route::get('/logs', 'indexLogs')->name('aplikasi.logs');

        // Only superadmin can delete logs
        Route::middleware(SuperadminMiddleware::class)->group(function () {
            Route::post('/logs/hapus', 'deleteLogs')->name('aplikasi.logs-hapus');
        });
    });
});


Route::prefix('monitoring-superadmin')->middleware([AuthMiddleware::class, SuperadminMiddleware::class])
    ->controller(MonitoringController::class)->group(function () {
        Route::get('/rapat', 'monitoringRapat')->name('monitoring-superadmin.rapat');
    });
