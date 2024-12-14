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
                <div class="card-header">
                    <h3>Konfigurasi Sistem</h3>
                    <small>Pengaturan konfigurasi sistem aplikasi</small>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('aplikasi.simpan-konfigurasi') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label class="form-label" for="lembaga">Lembaga <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Lembaga..." id="lembaga"
                                name="lembaga" required value="{{ $konfigurasi ? $konfigurasi->lembaga : old('lembaga') }}">
                            @error('lembaga')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="badanPeradilan">Badan Peradilan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" placeholder="Badan Peradilan..." id="badanPeradilan"
                                name="badanPeradilan" required
                                value="{{ $konfigurasi ? $konfigurasi->badan_peradilan : old('badanPeradilan') }}">
                            @error('badanPeradilan')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="wilayahHukum">Wilayah Hukum
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" placeholder="Wilayah Hukum..." id="wilayahHukum"
                                name="wilayahHukum" required
                                value="{{ $konfigurasi ? $konfigurasi->wilayah_hukum : old('wilayahHukum') }}">
                            @error('wilayahHukum')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kodeSatker">Kode Satuan Kerja
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" placeholder="Kode Satuan Kerja..." id="kodeSatker"
                                name="kodeSatker" required
                                value="{{ $konfigurasi ? $konfigurasi->kode_satker : old('kodeSatker') }}">
                            @error('kodeSatker')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="satuanKerja">Nama Satuan Kerja
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" placeholder="Nama Satuan Kerja..." id="satuanKerja"
                                name="satuanKerja" required
                                value="{{ $konfigurasi ? $konfigurasi->satuan_kerja : old('satuanKerja') }}">
                            @error('satuanKerja')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="alamat">Alamat
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="alamat" id="alamat" name="alamat" class="form-control" placeholder="Alamat..." required>{{ $konfigurasi ? $konfigurasi->alamat : old('alamat') }}</textarea>
                            @error('alamat')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="provinsi">Provinsi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Provinsi..." id="provinsi"
                                        name="provinsi" required
                                        value="{{ $konfigurasi ? $konfigurasi->provinsi : old('provinsi') }}">
                                </div>
                                @error('provinsi')
                                    <small class="text-danger mt-1">* {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="kota">Kota/Kabupaten
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Kota/Kabupaten..."
                                        id="kota" name="kota" required
                                        value="{{ $konfigurasi ? $konfigurasi->kota : old('kota') }}">
                                    @error('kota')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="kodePos">Kode Pos
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Kode Pos..." id="kodePos"
                                        name="kodePos" required
                                        value="{{ $konfigurasi ? $konfigurasi->kode_pos : old('kodePos') }}">
                                </div>
                                @error('kodePos')
                                    <small class="text-danger mt-1">* {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="telepon">Telepon
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Telepon..." id="telepon"
                                        name="telepon" required
                                        value="{{ $konfigurasi ? $konfigurasi->telepon : old('telepon') }}">
                                    @error('telepon')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control" placeholder="Email..." id="email"
                                        name="email" required
                                        value="{{ $konfigurasi ? $konfigurasi->email : old('email') }}">
                                    @error('email')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="website">Website
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Website..." id="website"
                                        name="website" required
                                        value="{{ $konfigurasi ? $konfigurasi->website : old('website') }}">
                                    @error('website')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-file mb-3">
                            <label class="form-label" for="logo">Logo
                                <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" aria-label="logo" id="logo" name="logo">
                            @error('logo')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                            @if ($konfigurasi)
                                <small class="text-danger mt-1">* Kosongkan jika tidak ingin memperbarui logo</small>
                            @endif
                        </div>
                        @if ($konfigurasi)
                            <div class="mt-1">
                                <img src="{{ asset('storage/' . $konfigurasi->logo) }}" alt="logo"
                                    class="img img-thumbnail" style="max-width: 200px">
                            </div>
                        @endif
                        <div class="mt-2">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
