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
                    <h3>Logs</h3>
                    @if (Auth::user()->roles == \App\Enum\RolesEnum::SUPERADMIN->value)
                        <button data-pc-animate="fade-in-scale" data-bs-toggle="modal" data-bs-target="#animateModal"
                            class="btn btn-primary btn-sm"><i class="ph-duotone ph-file-plus"></i>
                            Hapus
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Pengguna</th>
                                    <th>Ip Address</th>
                                    <th>User Agent</th>
                                    <th>Activity</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($logs as $item)
                                    <tr>
                                        <td style="vertical-align: top;" class="text-start">{{ $no }}</td>
                                        <td style="vertical-align: top;">{{ $item->user->name }}</td>
                                        <td style="vertical-align: top;">{{ $item->ip_address }}</td>
                                        <td style="text-wrap: wrap; vertical-align: top;">{{ $item->user_agent }}</td>
                                        <td style="text-wrap: wrap; vertical-align: top;">{{ $item->activity }}</td>
                                        <td>{{ $item->created_at }}</td>
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
    @if (Auth::user()->roles == \App\Enum\RolesEnum::SUPERADMIN->value)
        <form action="{{ route('aplikasi.logs-hapus') }}" method="POST">
            <div class="modal fade modal-animate" id="animateModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Hapus Logs Activity</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                        </div>
                        <div class="modal-body">
                            @method('POST')
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="tanggalAwal">Tanggal Awal
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="tanggalAwal" id="tanggalAwal"
                                    placeholder="Pilih Tanggal..." readonly required value=" {{ old('tanggalAwal') }}">
                                @error('tanggalAwal')
                                    <small class="text-danger mt-1">* {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="tanggalAkhir">Tanggal Akhir
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="tanggalAkhir" id="tanggalAkhir"
                                    placeholder="Pilih Tanggal..." readonly required value=" {{ old('tanggalAkhir') }}">
                                @error('tanggalAkhir')
                                    <small class="text-danger mt-1">* {{ $message }}</small>
                                @enderror
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

        <!-- Date picker -->
        <script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
        <script>
            (function() {
                const d_week1 = new Datepicker(document.querySelector("#tanggalAwal"), {
                    buttonClass: "btn",
                });
                const d_week2 = new Datepicker(document.querySelector("#tanggalAkhir"), {
                    buttonClass: "btn",
                });
            })();
        </script>
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
    @endif
@endsection
