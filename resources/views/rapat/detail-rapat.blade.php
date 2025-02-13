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
                    <h3 class="m-0">Detail Rapat</h3>
                    <a href="{{ route('rapat.index') }}">Kembali</a>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 pt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Nomor Rapat</p>
                                    <p class="mb-0 fw-bold">
                                        {{ $rapat->nomor_dokumen }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">TimeStamp</p>
                                    <p class="mb-0 fw-bold">
                                        Created At : {{ $rapat->created_at }}
                                        Last Updated : {{ $rapat->updated_at }}
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Perihal Rapat</p>
                                    <p class="mb-0 fw-bold">
                                        {{ $rapat->detailRapat->perihal }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Klasifikasi Rapat</p>
                                    <p class="mb-0 fw-bold">
                                        {{ $rapat->klasifikasiRapat->rapat }}
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Tanggal Rapat</p>
                                    <p class="mb-0 fw-bold">
                                        {{ Carbon\Carbon::createFromFormat('Y-m-d', $rapat->detailRapat->tanggal_rapat)->format('d-m-Y') }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Waktu Rapat</p>
                                    <p class="mb-0 fw-bold">
                                        {{ $rapat->detailRapat->jam_mulai }} @if ($rapat->detailRapat->jam_selesai != null)
                                            selesai {{ $rapat->detailRapat->jam_selesai }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <p class="mb-1 text-muted">Acara</p>
                            <p class="mb-0" style="text-align: justify;">
                                {!! $rapat->detailRapat->acara !!}
                            </p>
                        </li>
                        <li class="list-group-item px-0">
                            <p class="mb-1 text-muted">Agenda</p>
                            <p class="mb-0" style="text-align: justify;">
                                {!! $rapat->detailRapat->agenda !!}
                            </p>
                        </li>
                        <li class="list-group-item px-0">
                            <p class="mb-1 text-muted">Tempat</p>
                            <p class="mb-0" style="text-align: justify;">
                                {{ $rapat->detailRapat->tempat }}
                            </p>
                        </li>
                        <li class="list-group-item px-0">
                            <p class="mb-1 text-muted">Peserta</p>
                            <p class="mb-0" style="text-align: justify;">
                                {{ $rapat->detailRapat->peserta }}
                            </p>
                        </li>
                        @if (Auth::user()->roles != 'User' || Auth::user()->id == $rapat->dibuat)
                            <li class="list-group-item px-0">
                                <p class="mb-1 text-muted">Kelola Dokumen</p>
                                <a class="btn btn-sm btn-primary"
                                    href="{{ route('rapat.form-undangan', ['param' => Crypt::encrypt('edit'), 'id' => Crypt::encrypt($rapat->id)]) }}">
                                    <i class="fas fa-pencil-alt"></i> Edit Undangan
                                </a>
                                <a class="btn btn-sm btn-primary"
                                    href="{{ route('rapat.form-notula', ['id' => Crypt::encrypt($rapat->id)]) }}">
                                    <i class="fas fa-file-word"></i> {{ $rapat->detailRapat->notulen ? 'Edit' : 'Tambah' }}
                                    Notula
                                </a>
                                <a class="btn btn-sm btn-primary"
                                    href="{{ route('rapat.form-dokumentasi', ['id' => Crypt::encrypt($rapat->id)]) }}">
                                    <i class="fas fa-camera"></i> {{ $dokumentasi ? 'Edit' : 'Tambah' }} Dokumentasi
                                </a>
                            </li>
                        @endif

                        <li class="list-group-item px-0">
                            <p class="mb-1 text-muted">Cetak Dokumen</p>
                            <a target="_blank" class="btn btn-sm btn-warning"
                                href="{{ route('rapat.print-undangan', ['id' => Crypt::encrypt($rapat->id)]) }}">
                                <i class="fas fa-file-pdf"></i> Undangan
                            </a>
                            <button data-pc-animate="fade-in-scale" data-bs-toggle="modal" data-bs-target="#animateDaftarHadirModal"
                                class="btn btn-warning btn-sm"><i class="fas fa-file-pdf"></i>
                                Daftar Hadir
                            </button>
                            @if ($rapat->detailRapat->notulen != null)
                                <a target="_blank" class="btn btn-sm btn-warning"
                                    href="{{ route('rapat.print-notula', ['id' => Crypt::encrypt($rapat->id)]) }}">
                                    <i class="fas fa-file-pdf"></i> Notula
                                </a>
                            @endif
                            @if ($dokumentasi)
                                <a target="_blank" class="btn btn-sm btn-warning"
                                    href="{{ route('rapat.print-dokumentasi', ['id' => Crypt::encrypt($rapat->id)]) }}">
                                    <i class="fas fa-file-pdf"></i> Dokumentasi
                                </a>
                            @endif
                        </li>
                        @if (Auth::user()->roles != 'User' || Auth::user()->id == $rapat->dibuat)
                            @if ($dokumentasi)
                                <li class="list-group-item px-0">
                                    <p class="mb-1 text-muted">Unggah Dokumen</p>
                                    <button data-pc-animate="fade-in-scale" data-bs-toggle="modal"
                                        data-bs-target="#animateModal" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-file-pdf"></i> Unggah File Edoc
                                    </button>
                                    @if ($edoc)
                                        <a target="_blank" class="btn btn-sm btn-secondary"
                                            href="{{ asset('storage/' . $edoc->path_file_edoc) }}">
                                            <i class="fas fa-file-pdf"></i> Edoc File PDF
                                        </a>
                                        Last Update Uploaded : {{ $edoc->updated_at }}
                                    @endif
                                    <form action="{{ route('rapat.simpan-edoc') }}" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="modal fade modal-animate" id="animateModal" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Unggah File Edoc Rapat</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"> </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @method('POST')
                                                        @csrf
                                                        <div class="mb-3" hidden>
                                                            <input type="text" class="form-control" readonly
                                                                name="id" value="{{ Crypt::encrypt($rapat->id) }}">
                                                        </div>
                                                        <div class="form-file mb-3">
                                                            <label class="form-label" for="file">File Edoc
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="file" class="form-control" aria-label="file"
                                                                id="file" name="file" required>
                                                            <small class="text-danger mt-1">
                                                                Dokumen rapat yang diunggah harus berformat PDF, maksimal
                                                                ukuran file 10MB dan harus sudah ditandatangani.
                                                            </small>
                                                            @error('file')
                                                                <small class="text-danger mt-1">* {{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit"
                                                            class="btn btn-primary shadow-2">Unggah</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <script>
                                        var animateModal = document.getElementById('animateModal');
                                        animateModal.addEventListener('show.bs.modal', function(event) {
                                            var button = event.relatedTarget;
                                            var recipient = button.getAttribute('data-pc-animate');
                                            var modalTitle = animateModal.querySelector('.modal-title');
                                            // modalTitle.textContent = 'Animate Modal : ' + recipient;
                                            animateModal.classList.add('anim-' + recipient);
                                            if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
                                                document.body.classList.add('anim-' + recipient);
                                            }
                                        });
                                        animateModal.addEventListener('hidden.bs.modal', function(event) {
                                            removeClassByPrefix(animateModal, 'anim-');
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
                                </li>
                            @endif
                        @endif
                    </ul>
                    <hr>
                    <a href="{{ route('rapat.index') }}" class="btn btn-warning btn-sm mt-2">
                        <i class="fas fa-reply-all"></i> Kembali
                    </a>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <form target="_blank" action="{{ route('rapat.print-daftar-hadir', ['id' => Crypt::encrypt($rapat->id)]) }}"
        method="GET">
        <div class="modal fade modal-animate" id="animateDaftarHadirModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cetak Daftar Hadir</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">
                        @method('GET')
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="jumlahPeserta">Jumlah Peserta Rapat
                                <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="jumlahPeserta" name="jumlahPeserta" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary shadow-2">Lanjut</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        var animateModal = document.getElementById('animateModal');
        animateModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var recipient = button.getAttribute('data-pc-animate');
            var modalTitle = animateModal.querySelector('.modal-title');
            // modalTitle.textContent = 'Animate Modal : ' + recipient;
            animateModal.classList.add('anim-' + recipient);
            if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
                document.body.classList.add('anim-' + recipient);
            }
        });
        animateModal.addEventListener('hidden.bs.modal', function(event) {
            removeClassByPrefix(animateModal, 'anim-');
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
@endsection
