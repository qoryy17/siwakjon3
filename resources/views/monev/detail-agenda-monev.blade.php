@extends('layout.body')
@section('title', env('APP_ENV') . ' | ' . $title)
@section('content')
    <script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
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
            <!-- Table Agenda Monev -->
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0">{{ $formTitle }}</h3>
                    <small class="d-block mb-2">
                        Pengumpulan Arsip Laporan Monitoring dan Evaluasi Berserta Tindaklanjut
                    </small>
                    @if (Auth::user()->roles != App\Enum\RolesEnum::USER->value)
                        <button data-pc-animate="fade-in-scale" data-bs-toggle="modal" data-bs-target="#animateModalAdd"
                            class="btn btn-primary btn-sm"><i class="ph-duotone ph-file-plus"></i>
                            Tambah
                        </button>
                    @endif

                    <a href="{{ asset('storage/private/Format Laporan Monev - Author AMPUH PN LBP.docx') }}" download
                        class="btn btn-warning btn-sm">
                        <i class="fas fa-file-word"></i>
                        Unduh Template Laporan Monev
                    </a>
                    <a href="{{ asset('storage/private/Format Tindaklanjut - Author AMPUH PNLBP.docx') }}" download
                        class="btn btn-warning btn-sm">
                        <i class="fas fa-file-word"></i>
                        Unduh Template Tindaklanjut Monev
                    </a>

                    <a class="btn btn-secondary btn-sm" href="{{ route('monev.index') }}"><i class="fas fa-reply-all"></i>
                        Kembali</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert"> Error validasi formulir </div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-danger mt-1">* {{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th class="text-start">Judul</th>
                                    <th class="text-start">Tanggal</th>
                                    <th class="text-start">Periode</th>
                                    <th class="text-center" width="1%">File</th>
                                    <th class="text-start">Status</th>
                                    <th class="text-start">Diunggah</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($detailMonev as $item)
                                    @php
                                        $diunggah = \App\Models\User::find($item->diunggah);
                                    @endphp
                                    <tr>
                                        <td style="vertical-align: top;" class="text-start">{{ $no }}</td>
                                        <td style="vertical-align: top;" class="text-start">{{ $item->judul_monev }}</td>
                                        <td style="vertical-align: top;">
                                            {{ Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_monev)->format('d-m-Y') }}
                                        </td>
                                        <td style="vertical-align: top;">
                                            {{ $item->periodeMonev->periode }}
                                        </td>
                                        <td style="vertical-align: top;">
                                            @if ($item->path_monev != null)
                                                <a target="_blank" href="{{ asset('storage/' . $item->path_monev) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td style="vertical-align: top;">{{ $item->status }}</td>
                                        <td style="vertical-align: top;">
                                            @if ($item->diunggah != null)
                                                {{ $diunggah ? $diunggah->name : '' }} <br>
                                                <small>Timestamp :{{ now() }}</small>
                                            @endif
                                        </td>
                                        <td style="vertical-align: top;">{{ $item->created_at }}</td>
                                        <td style="vertical-align: top;">{{ $item->updated_at }}</td>
                                        <td style="vertical-align: top;">
                                            @if (Auth::user()->roles != App\Enum\RolesEnum::USER->value)
                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#animateModal{{ $no }}"
                                                    class="avtar avtar-xs btn-link-secondary">
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
                                                    action="{{ route('monev.hapus-monev', ['id' => Crypt::encrypt($item->id)]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <form action="{{ route('monev.perbarui-monev') }}" method="POST">
                                                    <div class="modal fade modal-animate"
                                                        id="animateModal{{ $no }}" tabindex="-1"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Agenda Laporan Monev</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <div class="mb-3" hidden>
                                                                        <label class="form-label" for="nomorAgenda">Nomor
                                                                            Agenda
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            name="nomorAgenda" id="nomorAgenda"
                                                                            placeholder="Nomor Agenda..."
                                                                            value="{{ Crypt::encrypt($agendaMonev->id) }}"
                                                                            required readonly>
                                                                    </div>
                                                                    <div class="mb-3" hidden>
                                                                        <label class="form-label" for="idAgenda">ID Agenda
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            name="idAgenda" id="idAgenda"
                                                                            placeholder="ID Agenda..."
                                                                            value="{{ Crypt::encrypt($item->id) }}"
                                                                            required readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="judulMonev">Judul
                                                                            Monev
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            name="judulMonev" id="judulMonev"
                                                                            placeholder="Judul Monev..."
                                                                            value="{{ $item->judul_monev }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="tanggalMonev{{ $no }}">Tanggal
                                                                            Monev
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            name="tanggalMonev"
                                                                            id="tanggalMonev{{ $no }}"
                                                                            placeholder="Select date" readonly required
                                                                            value="{{ Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_monev)->format('m/d/Y') }}">
                                                                        @error('tanggalMonev')
                                                                            <small class="text-danger mt-1">*
                                                                                {{ $message }}</small>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="periode">Periode
                                                                            Monev
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <select class="form-control" data-trigger
                                                                            name="periode" id="periode" required>
                                                                            <option value="">Pilih Periode Monev
                                                                            </option>
                                                                            @foreach ($periodeMonev as $itemPeriode)
                                                                                <option value="{{ $itemPeriode->id }}"
                                                                                    @if ($itemPeriode->id == $item->periode_monev_id) selected @endif>
                                                                                    {{ $itemPeriode->periode }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary shadow-2">Simpan</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <script type="text/javascript">
                                                    (function() {
                                                        const d_week = new Datepicker(document.querySelector("#tanggalMonev{{ $no }}"), {
                                                            buttonClass: "btn",
                                                        });
                                                    })();
                                                </script>
                                            @endif
                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#animateModalUnggah{{ $no }}"
                                                class="avtar avtar-xs btn-link-secondary">
                                                <i class="ti ti-file-text f-20"></i>
                                            </a>
                                            <form action="{{ route('monev.unggah-monev') }}" method="POST"
                                                enctype="multipart/form-data">
                                                <div class="modal fade modal-animate"
                                                    id="animateModalUnggah{{ $no }}" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Unggah Laporan Monev</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="mb-3" hidden>
                                                                    <label class="form-label" for="nomorAgenda">
                                                                        Nomor Agenda
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="text" class="form-control"
                                                                        name="nomorAgenda" id="nomorAgenda"
                                                                        placeholder="Nomor Agenda..."
                                                                        value="{{ Crypt::encrypt($agendaMonev->id) }}"
                                                                        required readonly>
                                                                </div>
                                                                <div class="mb-3" hidden>
                                                                    <label class="form-label" for="idAgenda">
                                                                        ID Agenda
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="text" class="form-control"
                                                                        name="idAgenda" id="idAgenda"
                                                                        placeholder="ID Agenda..."
                                                                        value="{{ Crypt::encrypt($item->id) }}" required
                                                                        readonly>
                                                                </div>
                                                                <div class="form-file mb-3">
                                                                    <label class="form-label" for="fileMonev">
                                                                        File PDF Laporan Monev & Tindaklanjut
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="file" class="form-control"
                                                                        aria-label="fileMonev" id="fileMonev"
                                                                        name="fileMonev">
                                                                    <small class="text-danger mt-1">
                                                                        * File PDF Laporan Monev & Tindaklanjut maksimal
                                                                        berukuran 10MB
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary shadow-2">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    @php
                                        $no++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    @if (Auth::user()->roles != App\Enum\RolesEnum::USER->value)
        <form action="{{ route('monev.simpan-monev') }}" method="POST">
            <div class="modal fade modal-animate" id="animateModalAdd" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Agenda Laporan Monev</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            @method('POST')
                            <div class="mb-3" hidden>
                                <label class="form-label" for="nomorAgenda">Nomor Agenda
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="nomorAgenda" id="nomorAgenda"
                                    placeholder="Nomor Agenda..." value="{{ Crypt::encrypt($agendaMonev->id) }}" required
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="judulMonev">Judul Monev
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="judulMonev" id="judulMonev"
                                    placeholder="Judul Monev...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="tanggalMonev">Tanggal Monev
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="tanggalMonev" id="tanggalMonev"
                                    placeholder="Select date" readonly required>
                                @error('tanggalMonev')
                                    <small class="text-danger mt-1">* {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="periode">Periode Monev
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" data-trigger name="periode" id="periode" required>
                                    <option value="">Pilih Periode Monev</option>
                                    @foreach ($periodeMonev as $itemPeriodeAdd)
                                        <option value="{{ $itemPeriodeAdd->id }}">{{ $itemPeriodeAdd->periode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary shadow-2">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script type="text/javascript">
            (function() {
                const d_week = new Datepicker(document.querySelector("#tanggalMonev"), {
                    buttonClass: "btn",
                });
            })();
        </script>
        <script>
            var animateModalAdd = document.getElementById('animateModalAdd');
            animateModalAdd.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var recipient = button.getAttribute('data-pc-animate');
                var modalTitle = animateModalAdd.querySelector('.modal-title');
                // modalTitle.textContent = 'Animate Modal : ' + recipient;
                animateModalAdd.classList.add('anim-' + recipient);
                if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
                    document.body.classList.add('anim-' + recipient);
                }
            });
            animateModalAdd.addEventListener('hidden.bs.modal', function(event) {
                removeClassByPrefix(animateModalAdd, 'anim-');
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
    @endif
@endsection
