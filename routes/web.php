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
use App\Http\Controllers\Manajemen\PengawasanController;
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
        Route::get('/dashboard/laporan-monev', 'pintasanMonev')->name('home.pintasan-monev');
        Route::get('/dashboard/surat-keputusan', 'pintasanSK')->name('home.pintasan-sk');
        Route::get('/dashboard/notifikasi', 'notifikasi')->name('home.notifikasi');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(RapatController::class)->group(function () {
        Route::get('/manajemen-rapat/rapat-dinas', 'indexRapat')->name('rapat.index');
        Route::get('/manajemen-rapat/rapat-dinas/form/{param}/{id}', 'formUndangan')->name('rapat.form-undangan');
        Route::get('/manajemen-rapat/rapat-dinas/notula/{param}/{id}', 'formNotula')->name('rapat.form-notula');
        Route::get('/manajemen-rapat/rapat-dinas/dokumentasi/{id}', 'formDokumentasi')->name('rapat.form-dokumentasi');

        Route::get('/manajemen-rapat/rapat-dinas/detail/{id}', 'detailRapat')->name('rapat.detail');
        Route::post('/manajemen-rapat/rapat-dinas/simpan', 'simpanRapat')->name('rapat.simpan');
        Route::post('/manajemen-rapat/rapat-dinas/edit', 'editRapat')->name('rapat.edit');
        Route::delete('/manajemen-rapat/rapat-dinas/hapus', 'hapusRapat')->name('rapat.hapus');
    });
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(PengawasanController::class)->group(function () {
        Route::get('/pengawasan-bidang/rapat-pengawasan', 'indexPengawasan')->name('pengawasan.index');
        Route::get('/manajemen-rapat/rapat-pengawasan/form/{param}/{id}', 'formUndangan')->name('pengawasan.form-undangan');
        Route::get('/manajemen-rapat/rapat-pengawasan/notula/{param}/{id}', 'formNotula')->name('pengawasan.form-notula');
        Route::get('/manajemen-rapat/rapat-pengawasan/dokumentasi/{id}', 'formDokumentasi')->name('pengawasan.form-dokumentasi');

        Route::get('/pengawasan-bidang/rapat-pengawasan/detail/{id}', 'detailPengawasan')->name('pengawasan.detail');
        Route::post('/pengawasan-bidang/rapat-pengawasan/simpan', 'simpanPengawasan')->name('pengawasan.simpan');
        Route::post('/pengawasan-bidang/rapat-pengawasan/edit', 'editPengawasan')->name('pengawasan.edit');
        Route::delete('/pengawasan-bidang/rapat-pengawasan/hapus', 'hapusPengawasan')->name('pengawasan.hapus');
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
    });
});
