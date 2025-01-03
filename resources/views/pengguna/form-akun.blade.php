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
                    <form action="{{ route('pengguna.simpan-akun') }}" method="POST">
                        @csrf
                        @method('POST')
                        @if (Crypt::decrypt($paramOutgoing) == 'update')
                            <div class="mb-3" hidden>
                                <input type="text" class="form-control" readonly name="id"
                                    value="{{ Crypt::encrypt($pengguna->id) }}">
                            </div>
                        @endif
                        <div class="mb-3" hidden>
                            <input type="text" class="form-control" name="param" readonly value="{{ $paramOutgoing }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pegawai">Pegawai
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" data-trigger name="pegawai" id="pegawai" required>
                                <option value="">Pilih Pegawai</option>
                                @foreach ($pegawai as $itemPegawai)
                                    <option value="{{ $itemPegawai->id }}"
                                        @if (old('pegawai') == $itemPegawai->id) selected  @elseif ($pengguna && $pengguna->pegawai_id == $itemPegawai->id) selected @endif>
                                        {{ $itemPegawai->nama }}</option>
                                @endforeach
                            </select>
                            @error('pegawai')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email
                                <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" placeholder="Email..." id="email" name="email"
                                required value="{{ $pengguna ? $pengguna->email : old('email') }}">
                            @error('email')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Password
                                <span class="text-danger">*</span>
                            </label>
                            <input type="password" class="form-control" placeholder="Password..." id="password"
                                name="password" {{ $pengguna ? $pengguna->password : '' }}>
                            @error('password')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                            @if ($pengguna)
                                <small class="text-danger mt-1">Kosongkan jika tidak ingin mengganti</small>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="unitKerja">Unit Kerja / Unit Pengawasan (Khusus Akun Hakim)
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" required data-trigger name="unitKerja" id="unitKerja">
                                <option value="">Pilih Unit Kerja</option>
                                @foreach ($unitKerja as $itemUnitKerja)
                                    <option value="{{ $itemUnitKerja->id }}"
                                        @if (old('unitKerja') == $itemUnitKerja->id) selected @elseif ($pengguna && $pengguna->unit_kerja_id == $itemUnitKerja->id) selected @endif>
                                        {{ $itemUnitKerja->unit_kerja }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unitKerja')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="active">Aktif
                                <span class="text-danger">*</span>
                            </label>
                            <select name="active" id="active" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="1"
                                    @if (old('active') == '1') selected @elseif ($pengguna && $pengguna->active == '1') selected @endif>
                                    Aktif</option>
                                <option value="T"
                                    @if (old('active') == '0') selected @elseif ($pengguna && $pengguna->active == '0') selected @endif>
                                    Non Aktif</option>
                            </select>
                            @error('active')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="role">Role
                                <span class="text-danger">*</span>
                            </label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="Superadmin"
                                    @if (old('role') == 'Superadmin') selected @elseif ($pengguna && $pengguna->roles == 'Superadmin') selected @endif>
                                    Superadmin
                                </option>
                                <option value="Administrator"
                                    @if (old('role') == 'Administrator') selected @elseif ($pengguna && $pengguna->roles == 'Administrator') selected @endif>
                                    Administrator
                                </option>
                                <option value="User"
                                    @if (old('role') == 'User') selected @elseif ($pengguna && $pengguna->roles == 'User') selected @endif>
                                    User
                                </option>
                            </select>
                            @error('role')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                Simpan
                            </button>
                            <button type="reset" class="btn btn-sm btn-secondary"><i class="fas fa-recycle"></i>
                                Batal
                            </button>
                            <a href="{{ route('pengguna.akun') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-reply-all"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
