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
                        sistem !
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
                                    <th>Tanggal Rapat</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-start">1</td>
                                    <td>90/W2.U4/PW1.1/X/2024</td>
                                    <td>Rapat Evaluasi Kinerja Periode Desember</td>
                                    <td>{{ date('d-m-Y') }}</td>
                                    <td>Agustina</td>
                                    <td>{{ now() }}</td>
                                    <td>{{ now() }}</td>
                                    <td>
                                        <a href="{{ route('rapat.detail', ['id' => 'null']) }}"
                                            class="avtar avtar-xs btn-link-secondary">
                                            <i class="ti ti-eye f-20"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <form action="{{ route('rapat.form-undangan', ['param' => Crypt::encrypt('add'), 'id' => 'null']) }}" method="POST">
        <div class="modal fade modal-animate" id="animateModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pilih Klasifikasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">
                        @method('POST')
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
