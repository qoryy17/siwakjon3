@include('layout.header')
@if (session()->has('success'))
    <script>
        'use strict';
        window.onload = function() {
            Swal.fire({
                icon: "success",
                title: "Notifikasi",
                text: "{{ session('success') }}"
            });
        }
    </script>
@elseif (session()->has('error'))
    <script>
        'use strict';
        window.onload = function() {
            Swal.fire({
                icon: "error",
                title: "Notifikasi",
                text: "{{ session('error') }}"
            });
        }
    </script>
@endif
@php
    $pegawai = \App\Helpers\ViewUser::pegawai();
@endphp
@if ($pegawai && $pegawai->foto != null)
    @php
        $foto = asset($pegawai->foto);
    @endphp
@else
    @php
        $foto = asset('assets/images/user.png');
    @endphp
@endif
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->
<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ $routeHome }}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ asset('siwakjon2.png') }}" alt="logo" style="max-width: 50px;" />
                <span class="badge bg-success rounded-pill ms-2 theme-version">SIWAKJON Version 3.0.0</span>
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
                    <a href="#!" class="pc-link">
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
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"> <i class="ph-duotone ph-files"></i></span>
                        <span class="pc-mtext">Pengawasan Bidang</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('pengawasan.index') }}">
                                Rapat Pengawasan
                            </a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('pengawasan.daftar-hakim-pengawas') }}">
                                Daftar Hakim Pengawas
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
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
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('monev.periode') }}">Periode Monev</a>
                        </li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
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
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"> <i class="ph-duotone ph-user-circle"></i></span>
                        <span class="pc-mtext">Manajemen Pengguna</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('pengguna.akun') }}">Akun</a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('pengguna.pegawai') }}">Pegawai</a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('pengguna.hakim-pengawas') }}">Hakim Pengawas</a>
                        </li>
                    </ul>
                </li>
                <li class="pc-item pc-caption">
                    <label>Pengaturan</label>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
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
                                href="{{ route('klasifikasi.index', ['param' => 'rapat']) }}">Klasifikasi Rapat</a>
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
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"> <i class="ph-duotone ph-monitor"></i></span>
                        <span class="pc-mtext">Pengaturan Aplikasi</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
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
                <div class="card nav-action-card bg-brand-color-4">
                    <div class="card-body"
                        style="background-image: url('{{ asset('assets/images/layout/nav-card-bg.svg') }}')">
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
                            <a href="#" class="arrow-none dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-offset="0,20">
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
                                        <a class="pc-user-links">
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
<!-- [ Header Topbar ] start -->
<header class="pc-header">
    <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item d-inline-flex">
                    <h4 class="mt-2"><span id="clock">00:00:00</span></h4>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item d-none d-md-inline-flex">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph-duotone ph-circles-four"></i>
                    </a>
                    <div class="dropdown-menu dropdown-qta dropdown-menu-end pc-h-dropdown">
                        <div class="overflow-hidden">
                            <div class="qta-links m-n1">
                                <a href="{{ route('home.pintasan-rapat') }}" class="dropdown-item">
                                    <i class="ph-duotone ph-files"></i>
                                    <span>Rapat Saya</span>
                                </a>
                                <a href="{{ route('home.pintasan-pengawasan') }}" class="dropdown-item">
                                    <i class="ph-duotone ph-files"></i>
                                    <span>Pengawasan</span>
                                </a>
                                <a href="{{ route('home.pintasan-monev') }}" class="dropdown-item">
                                    <i class="ph-duotone ph-file-pdf"></i>
                                    <span>Monev Saya</span>
                                </a>
                                <a href="{{ route('home.pintasan-sk') }}" class="dropdown-item">
                                    <i class="ph-duotone ph-file-pdf"></i>
                                    <span>Surat Keputusan</span>
                                </a>
                                <a href="{{ route('home.logs') }}" class="dropdown-item">
                                    <i class="ph-duotone ph-activity"></i>
                                    <span>Logs</span>
                                </a>
                                <a href="{{ route('home.version') }}" class="dropdown-item">
                                    <i class="ph-duotone ph-app-window"></i>
                                    <span>Version</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph-duotone ph-sun-dim"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
                            <i class="ph-duotone ph-moon"></i>
                            <span>Dark</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
                            <i class="ph-duotone ph-sun-dim"></i>
                            <span>Light</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change_default()">
                            <i class="ph-duotone ph-cpu"></i>
                            <span>Default</span>
                        </a>
                    </div>
                </li>
                <li class="pc-h-item">
                    <a class="pc-head-link pct-c-btn" href="#" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvas_pc_layout">
                        <i class="ph-duotone ph-gear-six"></i>
                    </a>
                </li>
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph-duotone ph-bell"></i>
                        <span class="badge bg-success pc-h-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Notifikasi</h5>
                        </div>
                        <div class="dropdown-body text-wrap header-notification-scroll position-relative"
                            style="max-height: calc(100vh - 235px)">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="avtar avtar-s bg-light-success">
                                                <i class="ph-duotone ph-shield-checkered f-18"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 me-3 position-relative">
                                                    <h6 class="mb-0 text-truncate">Security</h6>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <span class="text-sm">5 hour ago</span>
                                                </div>
                                            </div>
                                            <p class="position-relative mt-1 mb-2">Lorem Ipsum is simply dummy text of
                                                the printing and
                                                typesetting industry. Lorem Ipsum has been the industry's standard
                                                dummy text ever since the 1500s.</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown-footer">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-grid"><a href="{{ route('home.notifikasi') }}"
                                            class="btn btn-primary">Lihat Notifikasi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        <img src="{{ $foto }}" alt="user-image" class="user-avtar" />
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">{{ \App\Helpers\ViewUser::jabatan() }}</h5>
                        </div>
                        <div class="dropdown-body">
                            <div class="profile-notification-scroll position-relative"
                                style="max-height: calc(100vh - 225px)">
                                <ul class="list-group list-group-flush w-100">
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ $foto }}" alt="user-image"
                                                    class="wid-50 rounded-circle" />
                                            </div>
                                            <div class="flex-grow-1 mx-3">
                                                <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                                <a class="link-primary"
                                                    href="javascript:void(0);">{{ Auth::user()->email }}</a>
                                            </div>
                                            <span class="badge bg-primary">{{ Auth::user()->roles }}</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="dropdown-item">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-moon"></i>
                                                <span>Dark Mode</span>
                                            </span>
                                            <div class="form-check form-switch form-check-reverse m-0">
                                                <input class="form-check-input f-18" id="dark-mode" type="checkbox"
                                                    onclick="dark_mode()" role="switch" />
                                            </div>
                                        </div>
                                        <a href="#" class="dropdown-item">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-user-circle"></i>
                                                <span>Edit Profil</span>
                                            </span>
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item"
                                            data-pc-animate="fade-in-scale" data-bs-toggle="modal"
                                            data-bs-target="#animateModal">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-key"></i>
                                                <span>Ganti Password</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" class="dropdown-item">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-activity"></i>
                                                <span>Logs Aktivitas</span>
                                            </span>
                                        </a>
                                        <a href="javascript:void(0);" onclick="signOut();" class="dropdown-item">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-power"></i>
                                                <span>Logout</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<!-- [ Header ] end -->

<!-- [ Main Content ] start -->
@yield('content')
<!-- [ Main Content ] end -->
<form action="" method="POST">
    <div class="modal fade modal-animate" id="animateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Password Akun Kamu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label for="passwordLama">
                            Password Lama <span class="text-danger">*</span>
                        </label>
                        <input type="password" id="passwordLama" name="passwordLama" class="form-control" required
                            placeholder="Password Lama...">
                    </div>
                    <div class="mb-3">
                        <label for="passwordBaru">
                            Password Baru <span class="text-danger">*</span>
                        </label>
                        <input type="password" id="passwordBaru" name="PasswordBaru" class="form-control" required
                            placeholder="Password Baru...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary shadow-2">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form action="{{ route('auth.signout') }}" method="POST" id="formLogout">
    @method('POST')
    @csrf
</form>
<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col-sm-6 my-1">
                <p class="m-0">Made by {{ env('APP_AUTHOR') }}
                    <a href="https://www.instagram.com/qori_chairawan17/" target="_blank"> | Era DigiSoft
                        Solution</a>
                </p>
            </div>
            <div class="col-sm-6 ms-auto my-1">
                <ul class="list-inline footer-link mb-0 justify-content-sm-end d-flex">
                    <li class="list-inline-item">{{ env('APP_NAME') }}</li>
                    <li class="list-inline-item">
                        {{ env('APP_LICENSE') }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<script>
    function signOut() {
        let formLogout = document.getElementById('formLogout');
        formLogout.submit();
    }
</script>
<script>
    var animateModal = document.getElementById('animateModal');
    animateModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var recipient = button.getAttribute('data-pc-animate');
        var modalTitle = animateModal.querySelector('.modal-title');
        // modalTitle.textContent = 'Animate Modal : ' + recipient;
        animateModal.classList.add('anim-' + recipient);
        if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
            document.body.classList.add('anim-' + recipient);
        }
    });
    animateModal.addEventListener('hidden.bs.modal', function(event) {
        removeClassByPrefix(animateModal, 'anim-');
        removeClassByPrefix(document.body, 'anim-');
    });

    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
</script>

@include('layout.footer')
