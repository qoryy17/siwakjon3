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
                                                <th>Temuan</th>
                                                <th>Waktu Penyelesaian</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($temuan->exists())
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($temuan->get() as $itemTemuan)
                                                    <tr>
                                                        <td style="vertical-align: top;">{{ $no }}</td>
                                                        <td style="vertical-align: top;">
                                                            <p style="text-align: justify;">
                                                                <strong>Judul</strong> : {{ $itemTemuan->judul }}
                                                            </p>
                                                            <p style="text-align: justify;">
                                                                <strong>Kriteria</strong> : {{ $itemTemuan->kriteria }}
                                                            </p>
                                                            <p style="text-align: justify;">
                                                                <strong>Kondisi</strong> {{ $itemTemuan->kondisi }}
                                                            </p>
                                                            <p style="text-align: justify;">
                                                                <strong>Sebab</strong> : {{ $itemTemuan->sebab }}
                                                            </p>
                                                            <p style="text-align: justify;">
                                                                <strong>Akibat</strong> : {{ $itemTemuan->akibat }}
                                                            </p>
                                                            <p style="text-align: justify;">
                                                                <strong>Rekomendasi</strong> :
                                                                {{ $itemTemuan->rekomendasi }}
                                                            </p>
                                                        </td>
                                                        <td style="vertical-align: top;">
                                                            {{ $itemTemuan->waktu_penyelesaian }}
                                                        </td>
                                                        <td style="vertical-align: top;">
                                                            {{ $itemTemuan->created_at }}
                                                        </td>
                                                        <td style="vertical-align: top;">
                                                            {{ $itemTemuan->updated_at }}
                                                        </td>
                                                        <td style="vertical-align: top;">
                                                            <a href="javascript:void(0);"
                                                                class="avtar avtar-xs btn-link-secondary edit-temuan"
                                                                data-id="{{ Crypt::encrypt($itemTemuan->id) }}"
                                                                data-judul="{{ $itemTemuan->judul }}"
                                                                data-kondisi="{{ $itemTemuan->kondisi }}"
                                                                data-kriteria="{{ $itemTemuan->kriteria }}"
                                                                data-sebab="{{ $itemTemuan->sebab }}"
                                                                data-akibat="{{ $itemTemuan->akibat }}"
                                                                data-rekomendasi="{{ $itemTemuan->rekomendasi }}"
                                                                data-waktuPenyelesaian="{{ $itemTemuan->waktu_penyelesaian }}">
                                                                <i class="ti ti-eye f-20"></i>
                                                            </a>
                                                            <a href="#" class="avtar avtar-xs btn-link-secondary"
                                                                onclick=" Swal.fire({
                                                                    icon: 'warning',
                                                                    title: 'Hapus Data ?',
                                                                    text: 'Data yang dihapus tidak dapat dikembalikan !',
                                                                    showCancelButton: true,
                                                                    confirmButtonText: 'Hapus',
                                                                    cancelButtonText: 'Batal',
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        document.getElementById('deleteForm{{ $no }}').submit();
                                                                    }
                                                                });">
                                                                <i class="ti ti-trash f-20"></i>
                                                            </a>
                                                            <form id="deleteForm{{ $no }}"
                                                                action="{{ route('pengawasan.hapus-temuan', ['id' => Crypt::encrypt($itemTemuan->id)]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $no++;
                                                    @endphp
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6">
                                                        Temuan pengawasan belum tersedia, silahkan tambah isi temuan
                                                        pengawasan ya.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex mt-4" style="gap: 5px;">
                        <button data-pc-animate="fade-in-scale" data-bs-toggle="modal"
                            data-bs-target="#animateModalLaporan" class="btn btn-primary btn-sm">
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

                <div class="collapse" id="collapseDasarHukum">
                    <div class="card-body border-top">
                        <h5>Dasar Hukum Pengawasan</h5>
                        <ol>
                            <li>Undang-Undang Nomor: 48 Tahun 2009 Tentang Kekuasaan Kehakiman;</li>
                            <li>Undang-Undang Nomor: 02 Tahun 1986 sebagaimana diubah dengan Undang-Undang Nomor: 08 Tahun
                                2004,
                                dan terakhir diubah dengan Undang-Undang Nomor : 49 Tahun 2009 tentang Peradilan Umum;</li>
                            <li>Peraturan Pemerintah Nomor 5 Tahun 2019 tentang Jenis dan Tarif Atas Jenis Penerimaan Negara
                                Bukan Pajak Yang Berlaku Pada Mahkamah Agung Dan Badan Peradilan Yang Berada Di Bawahnya;
                            </li>
                            <li>Peraturan Mahkamah Agung Republik Indonesia Nomor 7 Tahun 2015 tentang Organisasi dan Tata
                                Kerja
                                Kepaniteraan Dan Kesekretariatan Peradilan;</li>
                            <li>Peraturan Mahkamah Agung Republik Indonesia Nomor 8 Tahun 2016 tentang Pengawasan dan
                                Pembinaan
                                Atasan Langsung Di Lingkungan Mahkamah Agung dan Badan Peradilan di Bawahnya, khususnya
                                Pasal 10
                                ayat (1) huruf a jo Pasal 3 ayat (1) dan (2);</li>
                            <li>Peraturan Mahkamah Agung Republik Indonesia Nomor 9 Tahun 2016 tentang Pedoman Penanganan
                                Pengaduan (Whistleblowing System) di Mahkamah Agung dan Badan Peradilan yang Berada di
                                bawahnya;
                            </li>
                            <li>Keputusan Direktur Jenderal Badan Peradilan Umum Nomor: 1939/DJU/SK/HM.02.3/10/2018 tentang
                                Pedoman Pemberkasan Arsip Perkara Yang Telah Diminutasi Pada Pengadilan Tingkat Pertama;
                            </li>
                            <li>Keputusan Ketua Mahkamah Agung RI Nomor: KMA/080/SK/VIII/2006 Tanggal 24 Agustus 2006
                                tentang
                                Pedoman Pelaksanaan Pengawasan di Lingkungan Lembaga Peradilan;</li>
                            <li>Keputusan Ketua Mahkamah Agung RI Nomor 2-144/KMA/SK/VIII/2022 Tentang Pedoman Pelayanan
                                Informasi di Pengadilan</li>
                            <li>Pedoman Pelaksanaan Tugas dan Administrasi Pengadilan Buku I dan Buku II (Edisi Revisi,
                                2007)
                                Tentang Pola Pembinaan dan Pengendalian Administrasi</li>
                            <li>Keputusan Ketua Mahkamah Agung RI Nomor 145/KMA/SK/VIII/2007 Tentang Pemberlakuan Buku IV
                                Pedoman Pelaksanaan Pengawasan di Lingkungan Badan Peradilan</li>
                            <li>Surat Keputusan Ketua Mahkamah Agung RI Nomor 58/KMA/SK/III/2019 Tentang Pedoman Pembangunan
                                Zona Integritas Menuju Wilayah Bebas dari Korupsi (WBK) dan Wilayah Birokrasi Bersih dan
                                Melayani (WBBM) pada Mahkamah Agung dan Badan Peradilan di Bawahnya</li>
                            <li>Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 90 Tahun 2021
                                Tentang Pembangunan dan Evaluasi Zona Integritas Menuju Wilayah Bebas dari Korupsi dan
                                Wilayah
                                Birokrasi Bersih dan Melayani di Instansi Pemerintah</li>
                            <li>Peraturan Sekretaris Mahkamah Agung RI Nomor 02 Tahun 2013 Tentang Pedoman Pelaksanaan dan
                                Pertanggungjawaban Belanja Negara di Lingkungan Mahkamah Agung dan Badan Peradilan
                                Dibawahnya
                            </li>
                            <li>Keputusan Direktur Jenderal Badan Peradilan Umum Mahkamah Agung Republik Indonesia Nomor
                                21/DJU/SK/OT.01.3/3/2022 Tentang Pembaruan Standar Operasional Prosedur (SOP) Kepaniteraan
                                Pada
                                Pengadilan Tinggi Dan Pengadilan Negeri</li>
                            <li>Keputusan Direktur Jenderal Badan Peradilan Umum Mahkamah Agung Republik Indonesia Nomor
                                114/DJU/SK.HM1.1.1/I/2024 Tentang Pembaruan Pedoman Standar Pelayanan Terpadu Satu Pintu
                                (PTSP)
                                Pada Pengadilan Tinggi dan Pengadilan Negeri</li>
                            <li>Keputusan Direktur Jenderal Badan Peradilan Umum Mahkamah Agung Republik Indonesia Nomor
                                142/DJU/SK.OT1.6/II/2024 Tentang Pemberlakuan Program Sertifikasi Mutu Pengadilan Unggul Dan
                                Tangguh (AMPUH) Di Lingkungan Peradilan Umum</li>
                            <li>Keputusan ketua Pengadilan Negeri Lubuk Pakam Kelas IA Nomor : 24/KPN/SK.HK
                                1.2.5/I/2024/PN.Lbp
                                Tentang Penunjukan Kordinator Pengawasan Dan Pengawas Bidang Pada
                                {{ $aplikasi->satuan_kerja }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- This form for make a report -->
    <form action="{{ route('pengawasan.simpan-laporan') }}" method="POST">
        <div class="modal fade modal-animate" id="animateModalLaporan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
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
                                    <textarea name="dasarHukum" id="dasarHukum" class="form-control" style="max-height: 10%;"
                                        placeholder="Dasar Hukum... Cth: Undang-Undang Nomor: 48 Tahun 2009 Tentang Kekuasaan Kehakiman;">{{ $pengawasan ? $pengawasan->dasar_hukum : '' }}</textarea>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

            // for form add temuan
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
    @if ($temuan != null)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // for form edit temuan
                let judulEdit = new SimpleMDE({
                    element: document.querySelector("#judulEdit"),
                });

                let kondisiEdit = new SimpleMDE({
                    element: document.querySelector("#kondisiEdit"),
                });

                let kriteriaEdit = new SimpleMDE({
                    element: document.querySelector("#kriteriaEdit"),
                });

                let sebabEdit = new SimpleMDE({
                    element: document.querySelector("#sebabEdit"),
                });

                let akibatEdit = new SimpleMDE({
                    element: document.querySelector("#akibatEdit"),
                });

                let rekomendasiEdit = new SimpleMDE({
                    element: document.querySelector("#rekomendasiEdit"),
                });

                const editButtons = document.querySelectorAll('.edit-temuan');
                const editModal = new bootstrap.Modal(document.getElementById('animateModalTemuanEdit'));
                const editForm = document.getElementById('formTemuanEdit');

                editButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const judul = this.getAttribute('data-judul');
                        const kondisi = this.getAttribute('data-kondisi');
                        const kriteria = this.getAttribute('data-kriteria');
                        const sebab = this.getAttribute('data-sebab');
                        const akibat = this.getAttribute('data-akibat');
                        const rekomendasi = this.getAttribute('data-rekomendasi');
                        const waktuPenyelesaian = this.getAttribute('data-waktuPenyelesaian');

                        document.getElementById('idTemuan').value = id;
                        document.getElementById('judulEdit').value = judul;
                        document.getElementById('kriteriaEdit').value = kriteria;
                        document.getElementById('sebabEdit').value = sebab;
                        document.getElementById('akibatEdit').value = akibat;
                        document.getElementById('rekomendasiEdit').value = rekomendasi;
                        document.getElementById('waktuPenyelesaianEdit').value = waktuPenyelesaian;

                        // loaded incoming data on simplemde
                        judulEdit.value(judul);
                        kondisiEdit.value(kondisi);
                        kriteriaEdit.value(kriteria);
                        sebabEdit.value(sebab);
                        akibatEdit.value(akibat);
                        rekomendasiEdit.value(rekomendasi);

                        editModal.show();
                    });
                });
            });
        </script>
    @endif
@endsection
