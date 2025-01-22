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
                    <h3>Rapat Pengawasan</h3>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Perhatian !</strong> Kepada para pengguna untuk dapat melengkapi dokumen rapat setelah
                        membuat di sistem ! <br>
                        <span class="text-danger fw-bold">Dilarang membuat rapat dengan tanggal mundur, karena terdeteksi
                            oleh sistem aplikasi !</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @if (
                        \App\Helpers\ViewUser::jabatan() == \App\Enum\JabatanEnum::HAKIM->value ||
                            Auth::user()->roles == 'Superadmin' ||
                            Auth::user()->roles == 'Administrator')
                        <a href="{{ route('pengawasan.form-undangan', ['param' => Crypt::encrypt('add'), 'id' => 'null']) }}"
                            class="btn btn-primary btn-sm">
                            <i class="ph-duotone ph-file-plus"></i> Tambah
                        </a>
                    @endif
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
                                        $wasbid = \App\Models\Manajemen\PengawasanBidangModel::where(
                                            'pengawasan_bidang_id',
                                            $item->detailRapat->id,
                                        )->first();
                                        $edoc = \App\Models\Manajemen\EdocWasbidModel::where('pengawasan_bidang_id', $wasbid->id)->first();
                                    @endphp
                                    <tr>
                                        <td style="vertical-align: top;" class="text-start">{{ $no }}</td>
                                        <td style="vertical-align: top;" class="text-start">{{ $item->nomor_dokumen }}</td>
                                        <td style="vertical-align: top;">{{ $item->detailRapat->perihal }}</td>
                                        <td style="vertical-align: top;" class="text-start">
                                            {{ \App\Helpers\TimeSession::convertDateToIndonesian($item->detailRapat->tanggal_rapat) }}
                                        </td>
                                        <td style="vertical-align: top;">
                                            @if ($edoc)
                                                <a target="_blank" href="{{ asset('storage/' . $edoc->path_file_tlhp) }}"
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
                                            <a href="{{ route('pengawasan.detail', ['id' => Crypt::encrypt($item->id)]) }}"
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
                                                    action="{{ route('pengawasan.hapus-rapat', ['id' => Crypt::encrypt($item->id)]) }}"
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
    <!-- Modal Notification -->
    <div id="modalNotification" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalNotificationTitle"
        aria-hidden="true">
        <x-modal.modal-notif-pengawasan />
    </div>
    <!-- End Modal Notification -->
    <script>
        window.onload = function() {
            let modal = new bootstrap.Modal(document.getElementById('modalNotification'), {
                keyboard: false
            });
            modal.show();
        }
    </script>
@endsection
