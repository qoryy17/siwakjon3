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
            <div class="card mb-5">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h3 class="m-0">{{ $formTitle }}</h3>
                    <a href="{{ $routeBack }}">Kembali</a>
                </div>
                <div class="card-body">
                    <h5 class="mb-3">Buat Laporan Pengawasan Bidang</h5>

                    @if ($pengawasan)
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
                                                <p class="mb-1 text-muted">Deskripsi Pengawasan</p>
                                                <p class="mb-0 fw-bold">
                                                    {{ $pengawasan ? $pengawasan->deskripsi_pengawasan : '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1 text-muted">Dasar Hukum</p>
                                                <p class="mb-0 fw-bold">
                                                    {!! $pengawasan ? $pengawasan->dasar_hukum : '' !!}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
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
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="pills-temuan" role="tabpanel" aria-labelledby="pills-temuan-tab">
                                <button data-pc-animate="fade-in-scale" data-bs-toggle="modal"
                                    data-bs-target="#animateModalTemuanAdd" class="btn btn-primary btn-sm">
                                    <i class="fas fa-file-pdf"></i> Tambah Temuan
                                </button>
                                <div class="table-responsive mt-3">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul Temuan</th>
                                                <th>Kondisi</th>
                                                <th>Kriteria</th>
                                                <th>Sebab</th>
                                                <th>Akibat</th>
                                                <th>Rekomendasi</th>
                                                <th>Waktu</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex mt-4" style="gap: 5px;">
                        <button data-pc-animate="fade-in-scale" data-bs-toggle="modal" data-bs-target="#animateModalLaporan"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-file-pdf"></i> {{ $pengawasan ? 'Edit' : 'Tambah' }} Laporan
                        </button>
                        @if ($pengawasan)
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
                        <a href="{{ route('pengawasan.detail', ['id' => Crypt::encrypt($rapat->id)]) }}"
                            class="btn btn-warning btn-sm">
                            <i class="fas fa-reply-all"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- This form for make a report -->
    <form action="{{ route('pengawasan.simpan-laporan') }}" method="POST">
        <div class="modal fade modal-animate" id="animateModalLaporan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $pengawasan ? 'Edit' : 'Tambah' }} Pengawasan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <div class="mb-3" hidden>
                            <label for="id">
                                ID
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" required value="{{ Crypt::encrypt($rapat->id) }}"
                                readonly id="id" name="id">
                        </div>
                        <div class="mb-3" hidden>
                            <label for="kodePengawasan">
                                Kode Pengawasan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" required value="{{ $kodePengawasan }}" readonly
                                id="kodePengawasan" name="kodePengawasan">
                        </div>
                        <div class="mb-3" hidden>
                            <input type="text" class="form-control" name="param" readonly
                                value="{{ Crypt::encrypt('save') }}">
                        </div>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-tab1-tab" data-bs-toggle="pill" href="#pills-tab1"
                                    role="tab" aria-controls="pills-tab1" aria-selected="true">Objek/Unit
                                    Pengawasan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-tab2-tab" data-bs-toggle="pill" href="#pills-tab2"
                                    role="tab" aria-controls="pills-tab2" aria-selected="false">Deskripsi
                                    Pengawasan</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-tab1" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="mb-3">
                                    <label class="form-label" for="unitKerja">Objek/Unit Pengawasan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control" data-trigger name="unitKerja" id="unitKerja" required>
                                        <option value="">Pilih Objek/Unit Pengawasan</option>
                                        @foreach ($unitKerja as $objek)
                                            <option value="{{ $objek->id }}"
                                                @if (old('unitKerja') == $objek->unit_kerja) selected @elseif($pengawasan && $pengawasan->objek_pengawasan == $objek->unit_kerja) selected @endif>
                                                {{ $objek->unit_kerja }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unitKerja')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="dasarHukum">Dasar Hukum
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="dasarHukum" id="dasarHukum" class="form-control"
                                        placeholder="Dasar Hukum... Cth: Undang-Undang Nomor: 48 Tahun 2009 Tentang Kekuasaan Kehakiman;">{{ $pengawasan ? $pengawasan->dasar_hukum : old('dasarHukum') }}</textarea>
                                    @error('dasarHukum')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-tab2" role="tabpanel" aria-labelledby="pills-tab2-tab">
                                <div class="mb-3">
                                    <label class="form-label" for="deskripsiPengawasan">Deskripsi Pengawasan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="deskripsiPengawasan" id="deskripsiPengawasan" class="form-control"
                                        placeholder="Deskripsi Pengawasan... Cth: Disiplin Pegawai, Tata Kelola BMN">{{ $pengawasan ? $pengawasan->deskripsi_pengawasan : old('deskripsiPengawasan') }}</textarea>
                                    @error('deskripsiPengawasan')
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

        <!-- This form for make a temuan wasbid-->
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
                                        <textarea name="waktuPenyelesaian" id="waktuPenyelesaian" class="form-control" placeholder="Waktu Penyelesaian...">{{ old('rekomendasi') }}</textarea>
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

    <!-- This form for tutorial tips -->
    <div class="modal fade modal-animate" id="animateModalTips" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Tips Pengisian Laporan Pengawasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <p style="text-align: justify;">
                        <strong>Perhatian !</strong>
                        Harap melengkapi pengisian data untuk laporan pengawasan bidang, jika data laporan pengawasan
                        bidang tidak lengkap maka tombol untuk cetak laporan tidak tersedia.

                        <br>
                        Adapun tahapan pengisian sebagai berikut :
                    <ol>
                        <li>Klik tombol <strong>"Buat Laporan"</strong>. Isi data valid pada formulir.</li>
                        <li>Setelah disimpan, klik tab temuan lalu isi temuan pada saat pengawasan.</li>
                        <li>Kemudian tahapan selanjutnya mengisi klik tombol <strong>"Kesimpulan & Rekomendasi"</strong>
                            lalu isi formulir kesimpulan dan rekomendasi hasil pengawasan</li>
                        <li>Setelah semua terisi dengan lengkap dan valid, kamu dapat mencetak laporan pengawasan bidang
                            pada halaman detail pengawasan</li>
                    </ol>
                    </p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var animateModalTips = document.getElementById('animateModalTips');
        animateModalTips.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var recipient = button.getAttribute('data-pc-animate');
            var modalTitle = animateModalTips.querySelector('.modal-title');
            // modalTitle.textContent = 'Animate Modal : ' + recipient;
            animateModalTips.classList.add('anim-' + recipient);
            if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
                document.body.classList.add('anim-' + recipient);
            }
        });
        animateModalTips.addEventListener('hidden.bs.modal', function(event) {
            removeClassByPrefix(animateModalTips, 'anim-');
            removeClassByPrefix(document.body, 'anim-');
        });

        var animateModalLaporan = document.getElementById('animateModalLaporan');
        animateModalLaporan.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var recipient = button.getAttribute('data-pc-animate');
            var modalTitle = animateModalLaporan.querySelector('.modal-title');
            // modalTitle.textContent = 'Animate Modal : ' + recipient;
            animateModalLaporan.classList.add('anim-' + recipient);
            if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
                document.body.classList.add('anim-' + recipient);
            }
        });
        animateModalLaporan.addEventListener('hidden.bs.modal', function(event) {
            removeClassByPrefix(animateModalLaporan, 'anim-');
            removeClassByPrefix(document.body, 'anim-');
        });

        var animateModalKesimpulan = document.getElementById('animateModalKesimpulan');
        animateModalKesimpulan.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var recipient = button.getAttribute('data-pc-animate');
            var modalTitle = animateModalKesimpulan.querySelector('.modal-title');
            // modalTitle.textContent = 'Animate Modal : ' + recipient;
            animateModalKesimpulan.classList.add('anim-' + recipient);
            if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
                document.body.classList.add('anim-' + recipient);
            }
        });
        animateModalKesimpulan.addEventListener('hidden.bs.modal', function(event) {
            removeClassByPrefix(animateModalKesimpulan, 'anim-');
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
    <script src="{{ asset('assets/js/plugins/simplemde.min.js') }}"></script>
    <script>
        (function() {
            new SimpleMDE({
                element: document.querySelector("#dasarHukum"),
            });

            new SimpleMDE({
                element: document.querySelector("#deskripsiPengawasan"),
            });

            new SimpleMDE({
                element: document.querySelector("#kesimpulan"),
            });

            new SimpleMDE({
                element: document.querySelector("#rekomendasi"),
            });

            new SimpleMDE({
                element: document.querySelector("#judul"),
            });

            new SimpleMDE({
                element: document.querySelector("#kondisi"),
            });

            new SimpleMDE({
                element: document.querySelector("#kriteria"),
            });

            new SimpleMDE({
                element: document.querySelector("#sebab"),
            });

            new SimpleMDE({
                element: document.querySelector("#akibat"),
            });

            new SimpleMDE({
                element: document.querySelector("#rekomendasi1"),
            });

        })();
    </script>
@endsection
