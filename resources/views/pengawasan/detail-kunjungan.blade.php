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
                    <h3 class="m-0">Detail Kunjungan Pengawasan</h3>
                    <a href="{{ route('kunjungan.index') }}">Kembali</a>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 pt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Kode Kunjungan</p>
                                    <p class="mb-0 fw-bold">
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Unit Pengawasan</p>
                                    <p class="mb-0 fw-bold">
                                        Kepaniteraan Hukum
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Dibuat Oleh</p>
                                    <p class="mb-0 fw-bold">
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">TimeStamp</p>
                                    <p class="mb-0 fw-bold">
                                        Created At :
                                        Last Updated :
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="mt-3">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Perhatian !</strong>
                            Kamu dapat menambahkan agenda kunjungan pengawasan lebih dari sekali dalam 1 bulan. <br>
                            Jika sudah berganti bulan, unggah hasil kunjungan yang sudah di tandatangani pada halaman detail
                            kunjungan ini, hasil kunjungan merupakan bahan monitoring oleh pimpinan dalam pelaksanaan
                            pengawasan !
                        </div>
                        <button class="btn btn-primary btn-sm" data-pc-animate="fade-in-scale" data-bs-toggle="modal"
                            data-bs-target="#animateModalAgendaAdd">
                            <i class="ph-duotone ph-file-plus"></i> Tambah
                        </button>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr style="background-color: #F4F7FA;">
                                    <td>No</td>
                                    <td>Tanggal Kunjungan</td>
                                    <td>Waktu Kunjungan</td>
                                    <td>Agenda</td>
                                    <td>Pembahasan</td>
                                    <td>Hakim Pengawas</td>
                                    <td class="text-center">Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="vertical-align: top;">1</td>
                                    <td style="vertical-align: top;">21 Desember 2024</td>
                                    <td style="vertical-align: top;">10:00 WIB</td>
                                    <td style="vertical-align: top;">Kunjungan Minggu Pertama</td>
                                    <td style="vertical-align:top; text-wrap: wrap;">Lorem ipsum dolor sit amet Lorem ipsum
                                        dolor sit amet
                                        consectetur adipisicing elit.
                                        Amet quibusdam consectetur sequi excepturi, dolores dolor sint id ipsa numquam rerum
                                        magnam, saepe vel voluptatem nemo ut est temporibus ratione vitae.</td>
                                    <td style="vertical-align: top;">Morailam Purba</td>
                                    <td style="vertical-align: top;">
                                        <a href="" class="avtar avtar-xs btn-link-secondary">
                                            <i class="ti ti-printer f-20"></i>
                                        </a>
                                        <a class="avtar avtar-xs btn-link-secondary">
                                            <i class="ti ti-edit f-20"></i>
                                        </a>
                                        <a href="" class="avtar avtar-xs btn-link-secondary">
                                            <i class="ti ti-trash f-20"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">1</td>
                                    <td style="vertical-align: top;">21 Desember 2024</td>
                                    <td style="vertical-align: top;">10:00 WIB</td>
                                    <td style="vertical-align: top;">Kunjungan Minggu Pertama</td>
                                    <td style="vertical-align:top; text-wrap: wrap;">Lorem ipsum dolor sit amet Lorem ipsum
                                        dolor sit amet
                                        consectetur adipisicing elit.
                                        Amet quibusdam consectetur sequi excepturi, dolores dolor sint id ipsa numquam rerum
                                        magnam, saepe vel voluptatem nemo ut est temporibus ratione vitae.</td>
                                    <td style="vertical-align: top;">Morailam Purba</td>
                                    <td style="vertical-align: top;">
                                        <a href="" class="avtar avtar-xs btn-link-secondary">
                                            <i class="ti ti-printer f-20"></i>
                                        </a>
                                        <a class="avtar avtar-xs btn-link-secondary">
                                            <i class="ti ti-edit f-20"></i>
                                        </a>
                                        <a href="" class="avtar avtar-xs btn-link-secondary">
                                            <i class="ti ti-trash f-20"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <a href="{{ route('kunjungan.index') }}" class="btn btn-warning btn-sm mt-2">
                        <i class="fas fa-reply-all"></i> Kembali
                    </a>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <!-- This form for make agenda (adding data action)-->
    <form action="{{ route('kunjungan.simpan-agenda') }}" method="POST">
        <div class="modal fade modal-animate" id="animateModalAgendaAdd" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Agenda Kunjungan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <div class="mb-3" hidden>
                            <input type="text" class="form-control" name="param" readonly
                                value="{{ Crypt::encrypt('save') }}">
                        </div>
                        <!-- Tab For temuan pengawasan bidang  -->
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-agenda-tab" data-bs-toggle="pill"
                                    href="#pills-agenda" role="tab" aria-controls="pills-agenda"
                                    aria-selected="true">Agenda Kunjungan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-pembahasan-tab" data-bs-toggle="pill"
                                    href="#pills-pembahasan" role="tab" aria-controls="pills-pembahasan"
                                    aria-selected="false">Pembahasan</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-agenda" role="tabpanel"
                                aria-labelledby="pills-agenda-tab">
                                <div class="mb-3">
                                    <label class="form-label" for="tanggal">Tanggal Kunjungan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="tanggal" id="tanggal"
                                        placeholder="Pilih Tanggal..." readonly required>
                                    @error('tanggal')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="waktu">Waktu Kunjungan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="waktu" id="waktu"
                                        placeholder="Waktu Kunjungan..." required>
                                    @error('waktu')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="agenda">Agenda
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="agenda" id="agenda" class="form-control" placeholder="Agenda..." required>{{ old('agenda') }}</textarea>
                                    @error('agenda')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-pembahasan" role="tabpanel"
                                aria-labelledby="pills-pembahasan-tab">
                                <div class="mb-3">
                                    <label class="form-label" for="pembahasan">Pembahasan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="pembahasan" id="pembahasan" class="form-control" placeholder="Pembahasan...">{{ old('pembahasan') }}</textarea>
                                    @error('pembahasan')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="hakim">Unit Pengawasan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control" required data-trigger name="hakim" id="hakim">
                                        <option value="">Pilih Hakim</option>
                                        @foreach ($hakim as $kimwas)
                                            <option value="{{ $kimwas->id }}"
                                                @if (old('unitKerja') == $kimwas->id) selected @endif>
                                                {{ $hakim->pegawai->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('hakim')
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
    <script>
        var animateModalAgendaAdd = document.getElementById('animateModalAgendaAdd');
        animateModalAgendaAdd.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var recipient = button.getAttribute('data-pc-animate');
            var modalTitle = animateModalAgendaAdd.querySelector('.modal-title');
            // modalTitle.textContent = 'Animate Modal : ' + recipient;
            animateModalAgendaAdd.classList.add('anim-' + recipient);
            if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
                document.body.classList.add('anim-' + recipient);
            }
        });
        animateModalAgendaAdd.addEventListener('hidden.bs.modal', function(event) {
            removeClassByPrefix(animateModalAgendaAdd, 'anim-');
            removeClassByPrefix(document.body, 'anim-');
        });
    </script>
    <!-- Simplemde -->
    <script src="{{ asset('assets/js/plugins/simplemde.min.js') }}"></script>
    <!--- Bootstrap bundle js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Date picker -->
    <script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
    <!-- Time picker -->
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <script>
        (function() {
            new SimpleMDE({
                element: document.querySelector("#pembahasan"),
            });

            const d_week = new Datepicker(document.querySelector("#tanggal"), {
                buttonClass: "btn",
            });

        })();

        document.querySelector('#waktu').flatpickr({
            enableTime: true,
            noCalendar: true
        });
    </script>
@endsection
