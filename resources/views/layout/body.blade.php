@include('layout.header')
@if (session('success') || session('error'))
    <script>
        window.onload = function() {
            Swal.fire({
                icon: "{{ session('success') ? 'success' : 'error' }}",
                title: "Notifikasi",
                text: "{{ session('success') ?? session('error') }}"
            });
        }
    </script>
@endif
@php
    $pegawai = \App\Helpers\ViewUser::pegawai();
    $app = \App\Models\Pengaturan\VersionModel::latest()->first();
    $foto = $pegawai && $pegawai->foto ? asset('storage/' . $pegawai->foto) : asset('assets/images/user.png');
@endphp
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->
@include('layout.sidebar')
<!-- [ Header Topbar ] start -->
<header class="pc-header" style="background-color: #fff;">
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
                                <a href="{{ route('monev.index') }}" class="dropdown-item">
                                    <i class="ph-duotone ph-file-pdf"></i>
                                    <span>Monev Saya</span>
                                </a>
                                <a href="{{ route('arsip.surat-keputusan') }}" class="dropdown-item">
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
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        <img src="{{ $foto }}" alt="user-image" class="user-avtar" />
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0 text-center" style="text-wrap: wrap;">
                                {{ \App\Helpers\ViewUser::jabatan() }}</h5>
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
                                        <a href="{{ route('home.profil') }}" class="dropdown-item">
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
                                        <a href="{{ route('home.logs') }}" class="dropdown-item">
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
<form action="{{ route('home.ganti-password') }}" method="POST">
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
                        <label for="password">
                            Password Baru <span class="text-danger">*</span>
                        </label>
                        <input type="password" id="password" name="password" class="form-control" required
                            placeholder="Password Baru...">
                        @error('password')
                            <small class="text-danger mt-1">* {{ $message }}</small>
                        @enderror
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
                <p class="m-0">Developed by {{ env('APP_AUTHOR') }} </p>
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
