@extends('layout.body')
@section('title', env('APP_ENV') . ' | ' . $title)
@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                @foreach ($breadcumbs as $bc)
                                    <li class="breadcrumb-item"><a href="{{ $bc['link'] }}"
                                            {{ $bc['page'] }}>{{ $bc['title'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- [ sample-page ] start -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-lg-5 col-xxl-3">
                            <div class="card overflow-hidden">
                                <div class="card-body position-relative">
                                    <div class="text-center mt-3">
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
                                        <div class="chat-avtar d-inline-flex mx-auto">
                                            <img class="rounded-circle img-fluid wid-90 img-thumbnail"
                                                src="{{ $foto }}" alt="User image">
                                            <i class="chat-badge bg-success me-2 mb-2"></i>
                                        </div>
                                        <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                        <p class="text-muted text-sm">
                                            {{ \App\Helpers\ViewUser::jabatan() }}
                                        </p>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <h5 class="mb-0">
                                                    {{ \App\Helpers\ViewUser::countTotalRapatUser() }}
                                                </h5>
                                                <small class="text-muted">Total Rapat Dibuat</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nav flex-column nav-pills list-group list-group-flush account-pills mb-0"
                                    id="user-set-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link list-group-item list-group-item-action active"
                                        id="user-set-profile-tab" data-bs-toggle="pill" href="#user-set-profile"
                                        role="tab" aria-controls="user-set-profile" aria-selected="true">
                                        <span class="f-w-500"><i class="ph-duotone ph-user-circle m-r-10"></i>
                                            Profil Saya
                                        </span>
                                    </a>
                                    <a class="nav-link list-group-item list-group-item-action" id="user-set-account-tab"
                                        data-bs-toggle="pill" href="#user-set-account" role="tab"
                                        aria-controls="user-set-account" aria-selected="false">
                                        <span class="f-w-500"><i class="ph-duotone ph-notebook m-r-10"></i>
                                            Edit Profil
                                        </span>
                                    </a>
                                    <a class="nav-link list-group-item list-group-item-action" id="user-set-passwort-tab"
                                        data-bs-toggle="pill" href="#user-set-passwort" role="tab"
                                        aria-controls="user-set-passwort" aria-selected="false">
                                        <span class="f-w-500"><i class="ph-duotone ph-key m-r-10"></i>
                                            Ganti Password
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-xxl-9">
                            <div class="tab-content" id="user-set-tabContent">
                                <div class="tab-pane fade show active" id="user-set-profile" role="tabpanel"
                                    aria-labelledby="user-set-profile-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Informasi Data Kamu</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item px-0 pt-0">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-1 text-muted">Nama</p>
                                                            <p class="mb-0">
                                                                <b>{{ $pegawai ? $pegawai->nama : $pengguna->name }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1 text-muted">NIP</p>
                                                            <p class="mb-0">
                                                                <b>{{ $pegawai ? $pegawai->nip : 'Tidak di temukan !' }}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item px-0">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-1 text-muted">Email</p>
                                                            <p class="mb-0">{{ $pengguna->email }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1 text-muted">Bergabung Sejak</p>
                                                            <p class="mb-0">
                                                                <b>{{ \App\Helpers\TimeSession::convertDateToIndonesian($pengguna->created_at) }}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item px-0">
                                                    <p class="mb-1 text-muted">Jabatan</p>
                                                    <p class="mb-0">
                                                        <b>
                                                            {{ $pegawai ? $pegawai->jabatan->jabatan : 'Tidak di temukan !' }}</b>
                                                    </p>
                                                </li>
                                                <li class="list-group-item px-0 pb-0">
                                                    <p class="mb-1 text-muted">Keterangan</p>
                                                    <p class="mb-0">
                                                        <b>
                                                            {{ $pegawai ? $pegawai->keterangan : 'Tidak di temukan !' }}
                                                        </b>
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="user-set-account" role="tabpanel"
                                    aria-labelledby="user-set-account-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Edit Profil Kamu</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('home.simpan-profil') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('POST')
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item px-0 pt-0">
                                                        <div class="row mb-0">
                                                            <label for="email"
                                                                class="col-form-label col-md-3 col-sm-12">
                                                                Email
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-md-9 col-sm-12">
                                                                <input type="email" class="form-control" name="email"
                                                                    id="email" value="{{ $pengguna->email }}"
                                                                    placeholder="Email...">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item px-0">
                                                        <div class="row mb-0">
                                                            <label for="nip"
                                                                class="col-form-label col-md-3 col-sm-12">
                                                                NIP
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-md-9 col-sm-12">
                                                                <input type="text" class="form-control" name="nip"
                                                                    id="nip"
                                                                    value="{{ $pegawai ? $pegawai->nip : '' }}"
                                                                    placeholder="NIP...">
                                                                <small class="text-danger mt-1">
                                                                    * Kosongkan jika tidak ada !
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item px-0">
                                                        <div class="row mb-0">
                                                            <label for="nama"
                                                                class="col-form-label col-md-3 col-sm-12">
                                                                Nama
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-md-9 col-sm-12">
                                                                <input type="text" class="form-control" name="nama"
                                                                    id="name" required
                                                                    value="{{ $pegawai ? $pegawai->nama : '' }}"
                                                                    placeholder="Nama...">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item px-0">
                                                        <div class="row mb-0">
                                                            <label for="keterangan"
                                                                class="col-form-label col-md-3 col-sm-12 ">
                                                                Keterangan
                                                            </label>
                                                            <div class="col-md-9 col-sm-12">
                                                                <textarea class="form-control" name="keterangan" name="keterangan" id="keterangan"></textarea>
                                                                <small class="text-danger mt-1">
                                                                    * Kosongkan jika tidak ada !
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item px-0">
                                                        <div class="row mb-0">
                                                            <label for="foto"
                                                                class="col-form-label col-md-3 col-sm-12 ">
                                                                Foto
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-md-9 col-sm-12">
                                                                <div class="form-file mb-3">
                                                                    <input type="file" class="form-control"
                                                                        aria-label="foto" id="foto" name="foto">
                                                                    <small class="text-danger">
                                                                        * Unggah jika ada, maksimal 5MB
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item px-0">
                                                        <button type="submit" class="btn btn-primary"
                                                            style="float: right;">Simpan</button>
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="user-set-passwort" role="tabpanel"
                                    aria-labelledby="user-set-passwort-tab">
                                    <div class="card alert alert-warning p-0">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-3">
                                                    <h4 class="alert-heading">Perhatian !</h4>
                                                    <p class="mb-2" style="text-align: justify;">
                                                        Gantilah password akun kamu secara berkala, untuk meningkatkan
                                                        keamanan akun kamu.
                                                    </p>
                                                    <a href="#" class="alert-link" style="text-align: justify;">
                                                        Jangan memberikan akses akun kamu kepada siapapun, untuk
                                                        menghindari penyalahgunaan otoritas dan sumber daya pada sistem
                                                        aplikasi ini !
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('home.ganti-password') }}" method="POST">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Ganti Password</h5>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item px-0">
                                                        <div class="row mb-0">
                                                            <label for="password"
                                                                class="col-form-label col-md-3 col-sm-12">
                                                                Password Baru <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-md-9 col-sm-12">
                                                                @csrf
                                                                @method('POST')
                                                                <input type="password" class="form-control"
                                                                    name="password" id="password" required
                                                                    placeholder="******">
                                                                <small class="text-danger mt-2">
                                                                    Password harus terdiri dari huruf besar, kecil, angka
                                                                    dan
                                                                    karakter
                                                                </small>
                                                                @error('password')
                                                                    <small class="text-danger mt-1">*
                                                                        {{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item px-0">
                                                        <button type="submit" class="btn btn-primary"
                                                            style="float: right;">Simpan
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
