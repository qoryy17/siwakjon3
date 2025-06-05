@extends('layout.body')
@section('title', env('APP_NAME') . ' | ' . $title)
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
            <div class="card mb-5">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h3 class="m-0">{{ $formTitle }}</h3>
                    <a href="{{ $routeBack }}">Kembali</a>
                </div>
                <div class="card-body">
                    <h5 class="mb-3">Buat Laporan Pengawasan Bidang</h5>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($pengawasan)
                        @if ($temuan->exists())
                            <div class="alert alert-warning" role="alert">
                                <p style="text-align: justify;" class="m-0">
                                    <strong>Perhatian !</strong>
                                    Kamu sudah mengisi temuan pengawasan nih, selanjutnya silahkan isi kesimpulan dan
                                    rekomendasi dari hasil pengawasan ya klik tombol berwarna hijau dibawah dengan tulisan
                                    <strong>"Kesimpulan & Rekomendasi"</strong>, setelah itu kamu dapat mencetak laporan
                                    pada
                                    halamanan <a title="Detail Pengawasan" href="{{ $routeBack }}"
                                        class="text-dark">Detail Pengawasan</a>
                                </p>
                            </div>
                        @else
                            <div class="alert alert-warning" role="alert">
                                <p style="text-align: justify;" class="m-0">
                                    <strong>Perhatian !</strong>
                                    Silahkan mengisi temuan pengawasan ya, Klik tab <strong>Temuan</strong> kemudian klik
                                    tombol <strong>Tambah Temuan</strong>, isi temuan pengawasan dan simpan
                                </p>
                            </div>
                        @endif
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-pengawasan-tab" data-bs-toggle="pill"
                                    href="#pills-pengawasan" role="tab" aria-controls="pills-pengawasan"
                                    aria-selected="true">Pengawasan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-temuan-tab" data-bs-toggle="pill" href="#pills-temuan"
                                    role="tab" aria-controls="pills-temuan" aria-selected="false">Temuan</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-pengawasan" role="tabpanel"
                                aria-labelledby="pills-home-tab">

                                <ul class="list-group list-group-flush mt-2">
                                    <li class="list-group-item px-0 pt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1 text-muted">Kode Pengawasan</p>
                                                <p class="mb-0 fw-bold">
                                                    {{ $pengawasan ? $pengawasan->kode_pengawasan : '' }}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1 text-muted">Dokumen Rapat</p>
                                                <p class="mb-0 fw-bold">
                                                    {{ $rapat->detailRapat->perihal }}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1 text-muted">Objek/Unit Pengawasan</p>
                                                <p class="mb-0 fw-bold">
                                                    {{ $pengawasan ? $pengawasan->objek_pengawasan : '' }}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1 text-muted">Deskripsi Ruang Lingkup Pengawasan</p>
                                                <p class="mb-0 fw-bold">
                                                    {!! $pengawasan ? $pengawasan->deskripsi_pengawasan : '' !!}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <p class="mb-1 text-muted">Hakim Pengawas</p>
                                        <p class="mb-0 fw-bold">
                                            @if ($pengawasan)
                                                @php
                                                    $hakim = json_decode($pengawasan->hakim_pengawas);
                                                @endphp
                                                <ul>
                                                    @foreach ($hakim as $pengawas)
                                                        <li style="font-weight: 800;">
                                                            {{ $pengawas->nama }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </p>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <p class="mb-1 text-muted">Dasar Hukum</p>
                                        <p class="mb-0 fw-bold">
                                            {!! $pengawasan ? $pengawasan->dasar_hukum : '' !!}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="pills-temuan" role="tabpanel" aria-labelledby="pills-temuan-tab">
                                @include('pengawasan.table-temuan')
                            </div>
                        </div>
                    @endif

                    <div class="d-flex mt-4" style="gap: 5px;">
                        <button data-pc-animate="fade-in-scale" data-bs-toggle="modal" data-bs-target="#animateModalLaporan"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-file-pdf"></i> {{ $pengawasan ? 'Edit' : 'Tambah' }} Laporan
                        </button>
                        @if ($pengawasan && $temuan->exists())
                            <button data-pc-animate="fade-in-scale" data-bs-toggle="modal"
                                data-bs-target="#animateModalKesimpulan" class="btn btn-primary btn-sm">
                                <i class="fas fa-file-pdf"></i> Kesimpulan &
                                Rekomendasi
                            </button>
                        @endif
                        <button data-pc-animate="fade-in-scale" data-bs-toggle="modal" data-bs-target="#animateModalTips"
                            class="btn btn-secondary btn-sm">
                            <i class="fas fa-info-circle"></i> Tutorial
                        </button>
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseDasarHukum" aria-expanded="false"
                            aria-controls="collapseDasarHukum">
                            <i class="fas fa-file"></i> Dasar Hukum
                        </button>
                        <a href="{{ route('pengawasan.detail', ['id' => Crypt::encrypt($rapat->id)]) }}"
                            class="btn btn-warning btn-sm">
                            <i class="fas fa-reply-all"></i> Kembali
                        </a>
                    </div>
                </div>
                @include('pengawasan.dasar-hukum')
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    @include('pengawasan.modal-tambah-laporan-pengawasan')
    @include('pengawasan.modal-tips')

    <!-- Control Modal Tips -->
    @if (!session()->has('success') || session()->has('error'))
        <script>
            window.onload = function() {
                let modal = new bootstrap.Modal(document.getElementById('animateModalTips'), {
                    keyboard: false
                });
                modal.show();
            }
        </script>
    @endif
    <!-- End Control Modal Tips -->
    @if ($pengawasan)
        <!-- This form for make a summary and recommendation -->
        <form action="{{ route('pengawasan.simpan-laporan') }}" method="POST">
            <div class="modal fade modal-animate" id="animateModalKesimpulan" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Kesimpulan & Rekomendasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            @method('POST')
                            <div class="mb-3" hidden>
                                <label for="id">
                                    ID
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" required
                                    value="{{ Crypt::encrypt($rapat->id) }}" readonly id="id" name="id">
                            </div>
                            <div class="mb-3" hidden>
                                <label for="kodePengawasan">
                                    Kode Pengawasan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" required value="{{ $kodePengawasan }}"
                                    readonly id="kodePengawasan" name="kodePengawasan">
                            </div>
                            <div class="mb-3" hidden>
                                <input type="text" class="form-control" name="param" readonly
                                    value="{{ Crypt::encrypt('update') }}">
                            </div>
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-tab3-tab" data-bs-toggle="pill"
                                        href="#pills-tab3" role="tab" aria-controls="pills-tab3"
                                        aria-selected="true">Kesimpulan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-tab4-tab" data-bs-toggle="pill" href="#pills-tab4"
                                        role="tab" aria-controls="pills-tab4" aria-selected="false">Rekomendasi</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-tab3" role="tabpanel"
                                    aria-labelledby="pills-tab3-tab">
                                    <div class="mb-3">
                                        <label class="form-label" for="kesimpulan">Kesimpulan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="kesimpulan" id="kesimpulan" class="form-control" placeholder="Kesimpulan...">{{ $pengawasan ? $pengawasan->kesimpulan : old('kesimpulan') }}</textarea>
                                        @error('kesimpulan')
                                            <small class="text-danger mt-1">* {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-tab4" role="tabpanel"
                                    aria-labelledby="pills-tab4-tab">
                                    <div class="mb-3">
                                        <label class="form-label" for="rekomendasi">Rekomendasi
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="rekomendasi" id="rekomendasi" class="form-control" placeholder="Rekomendasi...">{{ $pengawasan ? $pengawasan->rekomendasi : old('rekomendasi') }}</textarea>
                                        @error('rekomendasi')
                                            <small class="text-danger mt-1">* {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- This form for make a temuan wasbid (adding data action)-->
        <form action="{{ route('pengawasan.simpan-temuan') }}" method="POST">
            <div class="modal fade modal-animate" id="animateModalTemuanAdd" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Temuan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            @method('POST')
                            <div class="mb-3" hidden>
                                <label for="id">
                                    ID
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" required
                                    value="{{ Crypt::encrypt($rapat->id) }}" readonly id="id" name="id">
                            </div>
                            <div class="mb-3" hidden>
                                <label for="idWasbid">
                                    ID Pengawasan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" required
                                    value="{{ $pengawasan ? Crypt::encrypt($pengawasan->id) : '' }}" readonly
                                    id="idWasbid" name="idWasbid">
                            </div>
                            <div class="mb-3" hidden>
                                <input type="text" class="form-control" name="param" readonly
                                    value="{{ Crypt::encrypt('save') }}">
                            </div>
                            <!-- Tab For temuan pengawasan bidang  -->
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-judul-tab" data-bs-toggle="pill"
                                        href="#pills-judul" role="tab" aria-controls="pills-judul"
                                        aria-selected="true">Judul Temuan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-kondisi-tab" data-bs-toggle="pill"
                                        href="#pills-kondisi" role="tab" aria-controls="pills-kondisi"
                                        aria-selected="false">Kondisi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-kriteria-tab" data-bs-toggle="pill"
                                        href="#pills-kriteria" role="tab" aria-controls="pills-kriteria"
                                        aria-selected="false">Kriteria</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-sebab-tab" data-bs-toggle="pill" href="#pills-sebab"
                                        role="tab" aria-controls="pills-sebab" aria-selected="false">Sebab</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-akibat-tab" data-bs-toggle="pill" href="#pills-akibat"
                                        role="tab" aria-controls="pills-akibat" aria-selected="false">Akibat</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-rekomendasi-tab" data-bs-toggle="pill"
                                        href="#pills-rekomendasi" role="tab" aria-controls="pills-rekomendasi"
                                        aria-selected="false">Rekomendasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-waktu-penyelesaian-tab" data-bs-toggle="pill"
                                        href="#pills-waktu-penyelesaian" role="tab"
                                        aria-controls="pills-waktu-penyelesaian" aria-selected="false">Waktu
                                        Penyelesaian</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-judul" role="tabpanel"
                                    aria-labelledby="pills-judul-tab">
                                    <div class="mb-3">
                                        <label class="form-label" for="judul">Judul Temuan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="judul" id="judul" class="form-control" placeholder="Judul...">{{ old('judul') }}</textarea>
                                        @error('judul')
                                            <small class="text-danger mt-1">* {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-kondisi" role="tabpanel"
                                    aria-labelledby="pills-kondisi-tab">
                                    <div class="mb-3">
                                        <label class="form-label" for="kondisi">Kondisi
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="kondisi" id="kondisi" class="form-control" placeholder="Kondisi...">{{ old('kondisi') }}</textarea>
                                        @error('kondisi')
                                            <small class="text-danger mt-1">* {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-kriteria" role="tabpanel"
                                    aria-labelledby="pills-kriteria-tab">
                                    <div class="mb-3">
                                        <label class="form-label" for="kriteria">Kriteria
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="kriteria" id="kriteria" class="form-control" placeholder="Kriteria...">{{ old('kriteria') }}</textarea>
                                        @error('kriteria')
                                            <small class="text-danger mt-1">* {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-sebab" role="tabpanel"
                                    aria-labelledby="pills-sebab-tab">
                                    <div class="mb-3">
                                        <label class="form-label" for="sebab">Sebab
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="sebab" id="sebab" class="form-control" placeholder="Sebab...">{{ old('sebab') }}</textarea>
                                        @error('sebab')
                                            <small class="text-danger mt-1">* {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-akibat" role="tabpanel"
                                    aria-labelledby="pills-akibat-tab">
                                    <div class="mb-3">
                                        <label class="form-label" for="akibat">Akibat
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="akibat" id="akibat" class="form-control" placeholder="Akibat...">{{ old('akibat') }}</textarea>
                                        @error('akibat')
                                            <small class="text-danger mt-1">* {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-rekomendasi" role="tabpanel"
                                    aria-labelledby="pills-rekomendasi-tab">
                                    <div class="mb-3">
                                        <label class="form-label" for="rekomendasi1">Rekomendasi
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="rekomendasi" id="rekomendasi1" class="form-control" placeholder="Rekomendasi...">{{ old('rekomendasi') }}</textarea>
                                        @error('rekomendasi')
                                            <small class="text-danger mt-1">* {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-waktu-penyelesaian" role="tabpanel"
                                    aria-labelledby="pills-tab4-tab">
                                    <div class="mb-3">
                                        <label class="form-label" for="waktuPenyelesaian">Waktu Penyelesaian
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="waktuPenyelesaian" id="waktuPenyelesaian" class="form-control" placeholder="Waktu Penyelesaian...">{{ old('waktuPenyelesaian') }}</textarea>
                                        @error('waktuPenyelesaian')
                                            <small class="text-danger mt-1">* {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- End Tab temuan pengawasan bidang -->

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if ($temuan != null)
            <!-- This form for make a temuan wasbid (editing data action)-->
            <form action="{{ route('pengawasan.simpan-temuan') }}" method="POST" id="formTemuanEdit">
                <div class="modal fade modal-animate" id="animateModalTemuanEdit" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Temuan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                @method('POST')
                                <div class="mb-3" hidden>
                                    <label for="id">
                                        ID
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" required
                                        value="{{ Crypt::encrypt($rapat->id) }}" readonly id="id" name="id">
                                </div>
                                <div class="mb-3" hidden>
                                    <label for="idWasbid">
                                        ID Pengawasan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" required
                                        value="{{ $pengawasan ? Crypt::encrypt($pengawasan->id) : '' }}" readonly
                                        id="idWasbid" name="idWasbid">
                                </div>
                                <div class="mb-3" hidden>
                                    <label for="idTemuan">
                                        ID Temuan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" required value="" readonly
                                        id="idTemuan" name="idTemuan">
                                </div>
                                <div class="mb-3" hidden>
                                    <input type="text" class="form-control" name="param" readonly
                                        value="{{ Crypt::encrypt('update') }}">
                                </div>
                                <!-- Tab For temuan pengawasan bidang edit action -->
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-judulEdit-tab" data-bs-toggle="pill"
                                            href="#pills-judulEdit" role="tab" aria-controls="pills-judulEdit"
                                            aria-selected="true">Judul Temuan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-kondisiEdit-tab" data-bs-toggle="pill"
                                            href="#pills-kondisiEdit" role="tab" aria-controls="pills-kondisiEdit"
                                            aria-selected="false">Kondisi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-kriteriaEdit-tab" data-bs-toggle="pill"
                                            href="#pills-kriteriaEdit" role="tab" aria-controls="pills-kriteriaEdit"
                                            aria-selected="false">Kriteria</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-sebabEdit-tab" data-bs-toggle="pill"
                                            href="#pills-sebabEdit" role="tab" aria-controls="pills-sebabEdit"
                                            aria-selected="false">Sebab</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-akibatEdit-tab" data-bs-toggle="pill"
                                            href="#pills-akibatEdit" role="tab" aria-controls="pills-akibatEdit"
                                            aria-selected="false">Akibat</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-rekomendasiEdit-tab" data-bs-toggle="pill"
                                            href="#pills-rekomendasiEdit" role="tab"
                                            aria-controls="pills-rekomendasiEdit" aria-selected="false">Rekomendasi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-waktu-penyelesaianEdit-tab" data-bs-toggle="pill"
                                            href="#pills-waktu-penyelesaianEdit" role="tab"
                                            aria-controls="pills-waktu-penyelesaianEdit" aria-selected="false">Waktu
                                            Penyelesaian</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-judulEdit" role="tabpanel"
                                        aria-labelledby="pills-judulEdit-tab">
                                        <div class="mb-3">
                                            <label class="form-label" for="judulEdit">Judul Temuan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="judul" id="judulEdit" class="form-control" placeholder="Judul..."></textarea>
                                            @error('judul')
                                                <small class="text-danger mt-1">* {{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-kondisiEdit" role="tabpanel"
                                        aria-labelledby="pills-kondisiEdit-tab">
                                        <div class="mb-3">
                                            <label class="form-label" for="kondisiEdit">Kondisi
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="kondisi" id="kondisiEdit" class="form-control" placeholder="Kondisi..."></textarea>
                                            @error('kondisi')
                                                <small class="text-danger mt-1">* {{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-kriteriaEdit" role="tabpanel"
                                        aria-labelledby="pills-kriteriaEdit-tab">
                                        <div class="mb-3">
                                            <label class="form-label" for="kriteriaEdit">Kriteria
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="kriteria" id="kriteriaEdit" class="form-control" placeholder="Kriteria..."></textarea>
                                            @error('kriteria')
                                                <small class="text-danger mt-1">* {{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-sebabEdit" role="tabpanel"
                                        aria-labelledby="pills-sebabEdit-tab">
                                        <div class="mb-3">
                                            <label class="form-label" for="sebabEdit">Sebab
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="sebab" id="sebabEdit" class="form-control" placeholder="Sebab..."></textarea>
                                            @error('sebab')
                                                <small class="text-danger mt-1">* {{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-akibatEdit" role="tabpanel"
                                        aria-labelledby="pills-akibatEdit-tab">
                                        <div class="mb-3">
                                            <label class="form-label" for="akibatEdit">Akibat
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="akibat" id="akibatEdit" class="form-control" placeholder="Akibat..."></textarea>
                                            @error('akibat')
                                                <small class="text-danger mt-1">* {{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-rekomendasiEdit" role="tabpanel"
                                        aria-labelledby="pills-rekomendasiEdit-tab">
                                        <div class="mb-3">
                                            <label class="form-label" for="rekomendasiEdit">Rekomendasi
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="rekomendasi" id="rekomendasiEdit" class="form-control" placeholder="Rekomendasi..."></textarea>
                                            @error('rekomendasi')
                                                <small class="text-danger mt-1">* {{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-waktu-penyelesaianEdit" role="tabpanel"
                                        aria-labelledby="pills-tab4-tab">
                                        <div class="mb-3">
                                            <label class="form-label" for="waktuPenyelesaianEdit">Waktu Penyelesaian
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="waktuPenyelesaian" id="waktuPenyelesaianEdit" class="form-control"
                                                placeholder="Waktu Penyelesaian..."></textarea>
                                            @error('waktuPenyelesaian')
                                                <small class="text-danger mt-1">* {{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- End Tab temuan pengawasan bidang -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    @endif

    @include('pengawasan.script-modal')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Ckeditor js -->
    <script src="{{ asset('assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
    @include('pengawasan.script-ckeditor')
    @if ($temuan != null)
        @include('pengawasan.script-edit-ckeditor')
    @endif
@endsection
