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
                    <h3>Versi Sistem</h3>
                    <a href="{{ route('aplikasi.form-version', ['param' => Crypt::encrypt('add'), 'id' => 'null']) }}"
                        class="btn btn-primary btn-sm"><i class="ph-duotone ph-file-plus"></i>
                        Tambah
                    </a>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Release Date</th>
                                    <th>Category</th>
                                    <th>Patch Version</th>
                                    <th>Note</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($version as $item)
                                    <tr>
                                        <td class="text-start">1</td>
                                        {{-- <td>{{ $item->release_date }}</td> --}}
                                        <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $item->release_date)->format('d-m-Y') }}
                                        </td>
                                        <td>{{ $item->category }}</td>
                                        <td>{{ $item->patch_version }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('aplikasi.form-version', ['param' => Crypt::encrypt('edit'), 'id' => Crypt::encrypt($item->id)]) }}"
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
                                                action="{{ route('aplikasi.hapus-version', ['id' => Crypt::encrypt($item->id)]) }}"
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
