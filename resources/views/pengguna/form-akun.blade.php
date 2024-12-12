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
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h3 class="m-0">{{ $formTitle }}</h3>
                    <a href="{{ route('pengguna.akun') }}">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" placeholder="Email..." id="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Password
                                <span class="text-danger">*</span>
                            </label>
                            <input type="password" class="form-control" placeholder="Password..." id="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pegawai">Pegawai
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" data-trigger name="pegawai" id="pegawai">
                                <option value="">Pilih Pegawai</option>
                                <option value="Choice 1">Choice 1</option>
                                <option value="Choice 2">Choice 2</option>
                                <option value="Choice 3">Choice 3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="active">Aktif
                                <span class="text-danger">*</span>
                            </label>
                            <select name="active" id="active" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="1">Aktif</option>
                                <option value="0">Non Aktif</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="role">Role
                                <span class="text-danger">*</span>
                            </label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="Superadmin">Superadmin</option>
                                <option value="Administrator">Administrator</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                Simpan</button>
                            <button type="reset" class="btn btn-sm btn-secondary"><i class="fas fa-recycle"></i>
                                Batal</button>
                            <a href="{{ route('pengguna.akun') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-reply"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
