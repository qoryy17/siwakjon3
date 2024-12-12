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
                    <form action="" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label class="form-label" for="lembaga">Lembaga <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Lembaga..." id="lembaga" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="badanPeradilan">Badan Peradilan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" placeholder="Badan Peradilan..." id="badanPeradilan"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="wilayahHukum">Wilayah Hukum
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" placeholder="Wilayah Hukum..." id="wilayahHukum"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kodeSatker">Kode Satuan Kerja
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" placeholder="Kode Satuan Kerja..." id="kodeSatker"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="satuanKerja">Nama Satuan Kerja
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" placeholder="Nama Satuan Kerja..." id="satuanKerja"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="alamat">Alamat
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat..." required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="provinsi">Provinsi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Provinsi..." id="provinsi"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="kota">Kota/Kabupaten
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Kota/Kabupaten..."
                                        id="kota" required>
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
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="telepon">Telepon
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Telepon..." id="telepon"
                                        required>
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
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="website">Website
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Website..." id="website"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="form-file mb-3">
                            <label class="form-label" for="logo">Logo
                                <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" aria-label="logo" id="logo" required="">
                        </div>
                        <div class="mt-1">
                            <button class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
