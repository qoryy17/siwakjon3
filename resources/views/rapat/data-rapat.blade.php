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
                    <h3>Rapat Dinas</h3>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Perhatian !</strong> Kepada para pengguna untuk dapat melengkapi dokumen rapat setelah
                        membuat di
                        sistem ! <br>
                        <span class="text-danger fw-bold">Dilarang membuat rapat dengan tanggal mundur, karena terdeteksi
                            oleh sistem aplikasi !</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <button data-pc-animate="fade-in-scale" data-bs-toggle="modal" data-bs-target="#animateModal"
                        class="btn btn-primary btn-sm"><i class="ph-duotone ph-file-plus"></i>
                        Tambah
                    </button>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Nomor Rapat</th>
                                    <th>Perihal</th>
                                    <th class="text-start">Tanggal Rapat</th>
                                    <th>Klasifikasi</th>
                                    <th>Edoc</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($rapat as $item)
                                    @php
                                        $dibuat = \App\Models\User::find($item->dibuat);
                                        $edoc = App\Models\Manajemen\EdocRapatModel::where(
                                            'detail_rapat_id',
                                            $item->detailRapat->id,
                                        )->first();
                                    @endphp
                                    <tr>
                                        <td style="vertical-align: top;" class="text-start">{{ $no }}</td>
                                        <td style="vertical-align: top;" class="text-start">{{ $item->nomor_dokumen }}</td>
                                        <td style="vertical-align: top;">{{ $item->detailRapat->perihal }}</td>
                                        <td style="vertical-align: top;" class="text-start">
                                            {{ \App\Helpers\TimeSession::convertDateToIndonesian($item->detailRapat->tanggal_rapat) }}
                                        </td>
                                        <td style="vertical-align: top;">
                                            {{ $item->klasifikasiRapat->rapat }}
                                        </td>
                                        <td style="vertical-align: top;">
                                            @if ($edoc)
                                                <a target="_blank" href="{{ asset('storage/' . $edoc->path_file_edoc) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            @else
                                                <span class="text-danger">Belum diunggah</span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: top;">{{ $dibuat->name }}</td>
                                        <td style="vertical-align: top;">{{ $item->created_at }}</td>
                                        <td style="vertical-align: top;">{{ $item->updated_at }}</td>
                                        <td style="vertical-align: top;">
                                            <a href="{{ route('rapat.detail', ['id' => Crypt::encrypt($item->id)]) }}"
                                                class="avtar avtar-xs btn-link-secondary">
                                                <i class="ti ti-eye f-20"></i>
                                            </a>
                                            @if (Auth::user()->roles != 'User')
                                                <a href="#" class="avtar avtar-xs btn-link-secondary"
                                                    onclick=" Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Hapus Data ?',
                                                    text: 'Data yang dihapus tidak dapat dikembalikan ! \n Seluruh data dokumen rapat ini akan dihapus',
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
                                                    action="{{ route('rapat.hapus-rapat', ['id' => Crypt::encrypt($item->id)]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
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
    <form action="{{ route('rapat.form-undangan', ['param' => Crypt::encrypt('add'), 'id' => 'null']) }}" method="GET">
        <div class="modal fade modal-animate" id="animateModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pilih Klasifikasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">
                        @method('GET')
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="klasifikasiRapat">Klasifikasi Rapat
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" data-trigger name="klasifikasiRapat" id="klasifikasiRapat"
                                required>
                                <option value="">Pilih Klasifikasi Rapat</option>
                                @foreach ($klasifikasiRapat as $itemRapat)
                                    <option value="{{ $itemRapat->id }}">Rapat {{ $itemRapat->rapat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="klasifikasiJabatan">Klasifikasi Jabatan
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" data-trigger name="klasifikasiJabatan" id="klasifikasiJabatan"
                                required>
                                <option value="">Pilih Klasifikasi Jabatan</option>
                                @foreach ($klasifikasiJabatan as $itemJabatan)
                                    <option value="{{ $itemJabatan->id }}">
                                        Penyelenggara Rapat {{ $itemJabatan->jabatan }} | {{ $itemJabatan->kode_jabatan }}
                                    </option>
                                @endforeach
                            </select>
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
