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
                    <h3>Kunjungan Pengawasan</h3>
                    @if (
                        \App\Helpers\ViewUser::jabatan() == \App\Enum\JabatanEnum::HAKIM->value ||
                            Auth::user()->roles == 'Superadmin' ||
                            Auth::user()->roles == 'Administrator')
                        <a href="{{ route('kunjungan.form-kunjungan', ['param' => Crypt::encrypt('add'), 'id' => 'null']) }}"
                            class="btn btn-primary btn-sm">
                            <i class="ph-duotone ph-file-plus"></i> Tambah
                        </a>
                    @endif
                    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                        <strong>Perhatian !</strong> Harap mengisi kunjungan pengawasan oleh hakim pengawas bidang setiap
                        bulan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Unit Pengawasan</th>
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
                                @foreach ($kunjungan as $item)
                                    @php
                                        $dibuat = \App\Models\User::findOrFail($item->dibuat);
                                    @endphp
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>
                                            {{ $item->unitKerja->unit_kerja }}<br>
                                            Kode : {{ $item->kode_kunjungan }}
                                        </td>
                                        <td>
                                            @if ($item->path_file_edoc != null)
                                                <a target="_blank" href="{{ asset('storage/' . $item->path_file_edoc) }}"
                                                    class="btn btn-primary btn-sm"
                                                    title="File Edoc {{ $item->unitKerja->unit_kerja }}">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                Timestamp : {{ $item->waktu_unggah }}
                                            @else
                                                <span class="text-danger">
                                                    Belum Diunggah
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $dibuat->name }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('kunjungan.detail', ['id' => Crypt::encrypt($item->id)]) }}"
                                                class="avtar avtar-xs btn-link-secondary">
                                                <i class="ti ti-eye f-20"></i>
                                            </a>
                                            @if (Auth::user()->id == $item->dibuat || Auth::user()->roles == 'Superadmin' || Auth::user()->roles == 'Administrator')
                                                <a href="#" class="avtar avtar-xs btn-link-secondary"
                                                    onclick=" Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Hapus Data ?',
                                                    text: 'Data yang dihapus tidak dapat dikembalikan ! \n Seluruh data kunjungan pengawasan akan dihapus',
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
                                                    action="{{ route('kunjungan.hapus-kunjungan', ['id' => Crypt::encrypt($item->id)]) }}"
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
@endsection
