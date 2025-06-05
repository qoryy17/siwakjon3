<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ $routeHome }}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ asset('siwakjon2.png') }}" alt="logo" style="max-width: 50px;" />
                <span class="badge bg-success rounded-pill ms-2 theme-version">{{ env('APP_NAME') }}
                    {{ $app ? 'Version ' . $app->patch_version : '' }}
                </span>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label>Navigasi</label>
                </li>
                <li class="pc-item">
                    <a href="{{ $routeHome }}" class="pc-link">
                        <span class="pc-micon">
                            <i class="ph-duotone ph-gauge"></i>
                        </span>
                        <span class="pc-mtext">Beranda</span>
                    </a>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="javascript:void(0);" class="pc-link">
                        <span class="pc-micon"> <i class="ph-duotone ph-files"></i></span>
                        <span class="pc-mtext">Manajemen Rapat</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ route('rapat.index') }}">Rapat Dinas</a></li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="javascript:void(0);" class="pc-link">
                        <span class="pc-micon"> <i class="ph-duotone ph-files"></i></span>
                        <span class="pc-mtext">Pengawasan Bidang</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
                        @if (Auth::user()->roles === App\Enum\RolesEnum::ADMIN->value ||
                                Auth::user()->roles === App\Enum\RolesEnum::SUPERADMIN->value ||
                                \App\Helpers\ViewUser::jabatan() == \App\Enum\JabatanEnum::HAKIM->value ||
                                \App\Helpers\ViewUser::jabatan() == \App\Enum\JabatanEnum::WAKIL->value ||
                                \App\Helpers\ViewUser::jabatan() == \App\Enum\JabatanEnum::KETUA->value)
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('pengawasan.index') }}">
                                    Rapat Pengawasan
                                </a>
                            </li>
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('kunjungan.index') }}">
                                    Kunjungan Pengawasan
                                </a>
                            </li>
                        @endif

                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('pengawasan.daftar-hakim-pengawas') }}">
                                Daftar Hakim Pengawas
                            </a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('monitoring.index') }}">
                                Monitoring Pengawasan
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="javascript:void(0);" class="pc-link">
                        <span class="pc-micon"> <i class="ph-duotone ph-file-pdf"></i></span>
                        <span class="pc-mtext">Manajemen Monev</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('monev.index') }}">Laporan Monev</a>
                        </li>
                        @if (Auth::user()->roles == \App\Enum\RolesEnum::SUPERADMIN->value ||
                                Auth::user()->roles == \App\Enum\RolesEnum::ADMIN->value)
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('monev.periode') }}">Periode Monev</a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="javascript:void(0);" class="pc-link">
                        <span class="pc-micon"> <i class="ph-duotone ph-archive-box"></i></span>
                        <span class="pc-mtext">Manajemen Arsip</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('arsip.surat-keputusan') }}">Surat Keputusan</a>
                        </li>
                    </ul>
                </li>
                @if (Auth::user()->roles != \App\Enum\RolesEnum::USER->value)
                    <li class="pc-item pc-hasmenu">
                        <a href="javascript:void(0);" class="pc-link">
                            <span class="pc-micon"> <i class="ph-duotone ph-user-circle"></i></span>
                            <span class="pc-mtext">Manajemen Pengguna</span>
                            <span class="pc-arrow">
                                <i data-feather="chevron-right"></i>
                            </span>
                        </a>
                        <ul class="pc-submenu">
                            @if (Auth::user()->roles == \App\Enum\RolesEnum::SUPERADMIN->value)
                                <li class="pc-item">
                                    <a class="pc-link" href="{{ route('pengguna.akun') }}">Akun</a>
                                </li>
                                <li class="pc-item">
                                    <a class="pc-link" href="{{ route('pengguna.pegawai') }}">Pegawai</a>
                                </li>
                            @endif
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('pengguna.hakim-pengawas') }}">Hakim Pengawas</a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (Auth::user()->roles == \App\Enum\RolesEnum::SUPERADMIN->value)
                    <li class="pc-item pc-caption">
                        <label>Pengaturan</label>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="javascript:void(0);" class="pc-link">
                            <span class="pc-micon"> <i class="ph-duotone ph-gear-six"></i></span>
                            <span class="pc-mtext">Manajemen Pengaturan</span>
                            <span class="pc-arrow">
                                <i data-feather="chevron-right"></i>
                            </span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('jabatan.index') }}">Jabatan</a>
                            </li>
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('unitKerja.index') }}">Unit Kerja</a>
                            </li>
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('pejabatPengganti.index') }}">Pejabat Pengganti</a>
                            </li>
                            <li class="pc-item">
                                <a class="pc-link"
                                    href="{{ route('klasifikasi.index', ['param' => 'rapat']) }}">Klasifikasi
                                    Rapat</a>
                            </li>
                            <li class="pc-item">
                                <a class="pc-link"
                                    href="{{ route('klasifikasi.index', ['param' => 'surat']) }}">Klasifikasi
                                    Surat</a>
                            </li>
                            <li class="pc-item">
                                <a class="pc-link"
                                    href="{{ route('klasifikasi.index', ['param' => 'jabatan']) }}">Klasifikasi
                                    Jabatan</a>
                            </li>
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('klasifikasi.set-kode') }}">Set Kode Rapat</a>
                            </li>
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('rapat.set-rapat') }}">Set Rapat Dinas</a>
                            </li>
                        </ul>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="javascript:void(0);" class="pc-link">
                            <span class="pc-micon"> <i class="ph-duotone ph-monitor"></i></span>
                            <span class="pc-mtext">Pengaturan Aplikasi</span>
                            <span class="pc-arrow">
                                <i data-feather="chevron-right"></i>
                            </span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('aplikasi.ai-model') }}">AI Model</a>
                            </li>
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('aplikasi.pengembang') }}">Catatan Pengembang</a>
                            </li>
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('aplikasi.konfigurasi') }}">Konfigurasi</a>
                            </li>
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('aplikasi.version') }}">Version</a>
                            </li>
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('aplikasi.logs') }}">Logs</a>
                            </li>
                        </ul>
                    </li>
                @endif
                <div class="card nav-action-card bg-brand-color-4">
                    <div class="card-body"
                        style="background-image: url('{{ asset('assets/images/nav-card-bg.svg') }}')">
                        <h5 class="text-dark">Help Center</h5>
                        <p class="text-dark text-opacity-75">Butuh bantuan kendala masalah sistem ?</p>
                        <a href="https://wa.me/6281376472224" class="btn btn-primary" target="_blank">
                            Contact Now
                        </a>
                    </div>
                </div>
        </div>
        <div class="card pc-user-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ $foto }}" alt="user-image" class="user-avtar wid-45 rounded-circle" />
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="dropdown">
                            <a href="javascript:void(0);" title="{{ Auth::user()->name }}"
                                class="arrow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-offset="0,20">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 me-2">
                                        <h6 class="mb-0">{{ Str::limit(Auth::user()->name, 20) }}</h6>
                                        <small>Hak Akses : {{ Auth::user()->roles }}</small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="btn btn-icon btn-link-secondary avtar">
                                            <i class="ph-duotone ph-windows-logo"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li>
                                        <a class="pc-user-links" href="{{ route('home.profil') }}">
                                            <i class="ph-duotone ph-user"></i>
                                            <span>Profil Saya</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="pc-user-links" href="{{ route('home.pintasan-rapat') }}">
                                            <i class="ph-duotone ph-files"></i>
                                            <span>Rapat Saya</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="pc-user-links" href="{{ route('home.logs') }}">
                                            <i class="ph-duotone ph-activity"></i>
                                            <span>Logs</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="pc-user-links" onclick="signOut();">
                                            <i class="ph-duotone ph-power"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->
