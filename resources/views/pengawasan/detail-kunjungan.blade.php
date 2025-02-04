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
                                        {{ $kunjungan->kode_kunjungan }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Unit Pengawasan</p>
                                    <p class="mb-0 fw-bold">
                                        {{ $kunjungan->unitKerja->unit_kerja }}
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Dibuat Oleh</p>
                                    <p class="mb-0 fw-bold">
                                        @php
                                            $dibuat = \App\Models\User::findOrFail($kunjungan->dibuat);
                                        @endphp
                                        {{ $dibuat->name }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">TimeStamp</p>
                                    <p class="mb-0 fw-bold">
                                        Created At : {{ $kunjungan->created_at }}
                                        Last Updated : {{ $kunjungan->updated_at }}
                                    </p>
                                </div>
                            </div>
                        </li>
                        @if ($kunjungan->path_file_edoc != null)
                            <li class="list-group-item px-0">
                                <p class="mb-1 text-muted">File Edoc Kunjungan</p>
                                <a target="_blank" href="{{ asset('storage/' . $kunjungan->path_file_edoc) }}"
                                    class="btn btn-primary btn-sm"
                                    title="File Edoc {{ $kunjungan->unitKerja->unit_kerja }}">
                                    <i class="fas fa-file-pdf"></i> File Edoc Kunjungan
                                </a>
                                Timestamp : {{ $kunjungan->waktu_unggah }}
                            </li>
                        @endif
                    </ul>
                    <div class="mt-3">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Perhatian !</strong>
                            Kamu dapat menambahkan agenda kunjungan pengawasan lebih dari sekali dalam 1 bulan. <br>
                            Jika sudah berganti bulan, unggah hasil seluruh kunjungan yang sudah di tandatangani pada
                            halaman detail kunjungan ini, hasil kunjungan merupakan bahan monitoring oleh pimpinan dalam
                            pelaksanaan
                            pengawasan !
                        </div>
                        @if (
                            $kunjungan->dibuat == Auth::user()->id ||
                                Auth::user()->roles == 'Superadmin' ||
                                Auth::user()->roles == 'Administrator')
                            <a href="{{ route('kunjungan.form-kunjungan', ['param' => Crypt::encrypt('edit'), 'id' => Crypt::encrypt($kunjungan->id)]) }}"
                                class="btn btn-primary btn-sm">
                                <i class="ph-duotone ph-note-pencil"></i> Edit Kunjungan
                            </a>
                            <button class="btn btn-primary btn-sm" data-pc-animate="fade-in-scale" data-bs-toggle="modal"
                                data-bs-target="#animateModalAgendaAdd">
                                <i class="ph-duotone ph-file-plus"></i> Tambah Agenda
                            </button>
                            <button class="btn btn-secondary btn-sm" data-pc-animate="fade-in-scale" data-bs-toggle="modal"
                                data-bs-target="#animateModalFile">
                                <i class="ph-duotone ph-file-pdf"></i> Unggah File Edoc
                            </button>
                        @endif
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
                                    @if (
                                        $kunjungan->dibuat == Auth::user()->id ||
                                            Auth::user()->roles == 'Superadmin' ||
                                            Auth::user()->roles == 'Administrator')
                                        <td class="text-center">Aksi</td>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($detailKunjungan->exists())
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($detailKunjungan->get() as $item)
                                        @php
                                            $pengawas = \App\Models\Pengguna\PegawaiModel::findOrFail(
                                                $item->hakimPengawas->pegawai_id,
                                            );
                                        @endphp
                                        <tr>
                                            <td style="vertical-align: top;">{{ $no }}</td>
                                            <td style="vertical-align: top;">
                                                {{ \App\Helpers\TimeSession::convertDateToIndonesian($item->tanggal) }}
                                            </td>
                                            <td style="vertical-align: top;">
                                                {{ $item->waktu }} WIB
                                            </td>
                                            <td style="vertical-align: top;">
                                                {!! $item->agenda !!}
                                            </td>
                                            <td style="vertical-align:top; text-wrap: wrap;">
                                                {!! $item->pembahasan !!}
                                            </td>
                                            <td style="vertical-align: top;">
                                                {{ $pengawas->nama }}
                                            </td>
                                            @if (
                                                $kunjungan->dibuat == Auth::user()->id ||
                                                    Auth::user()->roles == 'Superadmin' ||
                                                    Auth::user()->roles == 'Administrator')
                                                <td style="vertical-align: top;">
                                                    <a href="{{ route('kunjungan.print-kunjungan', ['id' => Crypt::encrypt($item->id)]) }}"
                                                        class="avtar avtar-xs btn-link-secondary" target="_blank">
                                                        <i class="ti ti-printer f-20"></i>
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                        class="avtar avtar-xs btn-link-secondary edit-kunjungan"
                                                        data-id="{{ Crypt::encrypt($item->id) }}"
                                                        data-tanggal="{{ Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal)->format('m/d/Y') }}"
                                                        data-waktu="{{ $item->waktu }}" data-agenda="{{ $item->agenda }}"
                                                        data-pembahasan="{{ $item->pembahasan }}"
                                                        data-hakim="{{ $item->hakim_pengawas_id }}">
                                                        <i class="ti ti-edit f-20"></i>
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
                                                        action="{{ route('kunjungan.hapus-agenda', ['id' => Crypt::encrypt($item->id)]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">
                                            Belum ada agenda kunjungan pengawasan...
                                        </td>
                                    </tr>
                                @endif

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

    @if (
        $kunjungan->dibuat == Auth::user()->id ||
            Auth::user()->roles == 'Superadmin' ||
            Auth::user()->roles == 'Administrator')

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
                                    <div class="mb-3" hidden>
                                        <label class="form-label" for="idKunjungan">ID Kunjungan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="idKunjungan" id="idKunjungan"
                                            placeholder="ID Kunjungan..." value="{{ Crypt::encrypt($kunjungan->id) }}"
                                            readonly required>
                                    </div>
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
                                        <label class="form-label" for="hakim">Hakim Pengawas
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" required data-trigger name="hakim" id="hakim">
                                            <option value="">Pilih Hakim</option>
                                            @foreach ($hakim as $kimwas)
                                                <option value="{{ $kimwas->id }}"
                                                    @if (old('unitKerja') == $kimwas->id) selected @endif>
                                                    {{ $kimwas->pegawai->nama }}
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
        @if ($detailKunjungan->exists())
            <form action="{{ route('kunjungan.simpan-agenda') }}" method="POST" id="formAgendaEdit">
                <div class="modal fade modal-animate" id="animateModalAgendaEdit" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Agenda Kunjungan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                @method('POST')
                                <div class="mb-3" hidden>
                                    <input type="text" class="form-control" name="param" readonly
                                        value="{{ Crypt::encrypt('update') }}">
                                </div>
                                <!-- Tab For temuan pengawasan bidang  -->
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-agendaEdit-tab" data-bs-toggle="pill"
                                            href="#pills-agendaEdit" role="tab" aria-controls="pills-agendaEdit"
                                            aria-selected="true">Agenda Kunjungan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-pembahasanEdit-tab" data-bs-toggle="pill"
                                            href="#pills-pembahasanEdit" role="tab"
                                            aria-controls="pills-pembahasanEdit" aria-selected="false">Pembahasan</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-agendaEdit" role="tabpanel"
                                        aria-labelledby="pills-agendaEdit-tab">
                                        <div class="mb-3" hidden>
                                            <label class="form-label" for="idKunjungan">ID Kunjungan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="idKunjungan"
                                                id="idKunjungan" placeholder="ID Kunjungan..."
                                                value="{{ Crypt::encrypt($kunjungan->id) }}" readonly required>
                                        </div>
                                        <div class="mb-3" hidden>
                                            <label class="form-label" for="idAgenda">ID Agenda
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="idAgenda" id="idAgenda"
                                                placeholder="ID Agenda..." value="" readonly required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="tanggalEdit">Tanggal Kunjungan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="tanggal" id="tanggalEdit"
                                                placeholder="Pilih Tanggal..." readonly required>
                                            @error('tanggal')
                                                <small class="text-danger mt-1">* {{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="waktuEdit">Waktu Kunjungan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="waktu" id="waktuEdit"
                                                placeholder="Waktu Kunjungan..." required>
                                            @error('waktu')
                                                <small class="text-danger mt-1">* {{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="agendaEdit">Agenda
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="agenda" id="agendaEdit" class="form-control" placeholder="Agenda..." required></textarea>
                                            @error('agenda')
                                                <small class="text-danger mt-1">* {{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-pembahasanEdit" role="tabpanel"
                                        aria-labelledby="pills-pembahasanEdit-tab">
                                        <div class="mb-3">
                                            <label class="form-label" for="pembahasanEdit">Pembahasan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="pembahasan" id="pembahasanEdit" class="form-control" placeholder="Pembahasan..."></textarea>
                                            @error('pembahasan')
                                                <small class="text-danger mt-1">* {{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="hakimEdit">Hakim Pengawas
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control" required data-trigger name="hakim"
                                                id="hakimEdit">
                                                <option value="">Pilih Hakim</option>
                                                @foreach ($hakim as $kimwas)
                                                    <option value="{{ $kimwas->id }}">
                                                        {{ $kimwas->pegawai->nama }}
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

            <form action="{{ route('kunjungan.simpan-edoc') }}" method="POST" enctype="multipart/form-data">
                <div class="modal fade modal-animate" id="animateModalFile" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Unggah File Edoc Kunjungan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                @method('POST')
                                @csrf
                                <div class="mb-3" hidden>
                                    <input type="text" class="form-control" readonly name="id"
                                        value="{{ Crypt::encrypt($kunjungan->id) }}">
                                </div>
                                <div class="form-file mb-3">
                                    <label class="form-label" for="file">File Edoc
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" class="form-control" aria-label="file" id="file"
                                        name="file" required>
                                    <small class="text-danger mt-1">
                                        Dokumen kunjungan harus sesuai dengan jumlah agenda yang serta berformat PDF,
                                        maksimal ukuran file 10MB dan harus sudah ditandatangani.
                                    </small>
                                    @error('file')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary shadow-2">Unggah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
        <!-- Simplemde -->
        <script src="{{ asset('assets/js/plugins/simplemde.min.js') }}"></script>
        <!--- Bootstrap bundle js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Date picker -->
        <script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
        <!-- Time picker -->
        <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
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

            var animateModalAgendaEdit = document.getElementById('animateModalAgendaEdit');
            animateModalAgendaEdit.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var recipient = button.getAttribute('data-pc-animate');
                var modalTitle = animateModalAgendaEdit.querySelector('.modal-title');
                // modalTitle.textContent = 'Animate Modal : ' + recipient;
                animateModalAgendaEdit.classList.add('anim-' + recipient);
                if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
                    document.body.classList.add('anim-' + recipient);
                }
            });
            animateModalAgendaEdit.addEventListener('hidden.bs.modal', function(event) {
                removeClassByPrefix(animateModalAgendaEdit, 'anim-');
                removeClassByPrefix(document.body, 'anim-');
            });

            var animateModalFile = document.getElementById('animateModalFile');
            animateModalFile.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var recipient = button.getAttribute('data-pc-animate');
                var modalTitle = animateModalFile.querySelector('.modal-title');
                // modalTitle.textContent = 'Animate Modal : ' + recipient;
                animateModalFile.classList.add('anim-' + recipient);
                if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
                    document.body.classList.add('anim-' + recipient);
                }
            });
            animateModalFile.addEventListener('hidden.bs.modal', function(event) {
                removeClassByPrefix(animateModalFile, 'anim-');
                removeClassByPrefix(document.body, 'anim-');
            });
        </script>
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
        @if ($detailKunjungan->exists())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // for form edit temuan
                    let pembahasanEdit = new SimpleMDE({
                        element: document.querySelector("#pembahasanEdit"),
                    });

                    const editButtons = document.querySelectorAll('.edit-kunjungan');
                    const editModal = new bootstrap.Modal(document.getElementById('animateModalAgendaEdit'));
                    const editForm = document.getElementById('formAgendaEdit');

                    editButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const id = this.getAttribute('data-id');
                            const tanggal = this.getAttribute('data-tanggal');
                            const waktu = this.getAttribute('data-waktu');
                            const agenda = this.getAttribute('data-agenda');
                            const pembahasan = this.getAttribute('data-pembahasan');
                            const hakimPengawas = this.getAttribute('data-hakim');

                            document.getElementById('idAgenda').value = id;
                            document.getElementById('tanggalEdit').value = tanggal;
                            document.getElementById('waktuEdit').value = waktu;
                            document.getElementById('agendaEdit').value = agenda;
                            document.getElementById('pembahasanEdit').value = pembahasan;
                            // document.getElementById('hakimEdit').value = hakimPengawas;
                            const selectHakim = document.getElementById('hakimEdit');

                            selectHakim.value = hakimPengawas;

                            if (selectHakim.value !== hakimPengawas) {
                                const options = selectHakim.querySelectorAll('option');
                                options.forEach(option => {
                                    if (option.value == hakimPengawas) {
                                        option.selected = true;
                                    }
                                });
                            }
                            // loaded incoming data on simplemde
                            pembahasanEdit.value(pembahasan);
                            editModal.show();
                        });
                    });
                });
            </script>
        @endif
    @endif

@endsection
