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
                    <h3>Arsip Surat Keputusan</h3>
                    <small class="d-block mb-2">Arsip Elektronik Seluruh Surat Keputusan</small>
                    <a href="{{ route('arsip.form-sk', ['param' => Crypt::encrypt('add'), 'id' => 'null']) }}"
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
                                    <th class="text-start">Nomor</th>
                                    <th class="text-start">Judul</th>
                                    <th class="text-start" style="width: 5%;">Tanggal Terbit</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    <th>Diunggah</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($arsipSK as $item)
                                    @php
                                        $diunggah = \App\Models\User::find($item->diunggah);
                                    @endphp
                                    <tr>
                                        <td class="text-start" style="vertical-align: top;">{{ $no }}</td>
                                        <td class="text-start" style="vertical-align: top;">{{ $item->nomor }}</td>
                                        <td class="text-start" style="text-wrap: wrap;">{{ $item->judul }}</td>
                                        <td style="vertical-align: top;">
                                            {{ Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_terbit)->format('d-m-Y') }}
                                        </td>
                                        <td style="vertical-align: top;">
                                            <a target="_blank" href="{{ asset('storage/' . $item->path_file_sk) }}"
                                                title="{{ $item->judul }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        </td>
                                        <td style="vertical-align: top;">{{ $item->status }}</td>
                                        <td style="vertical-align: top;">{{ $diunggah->name }}</td>
                                        <td style="vertical-align: top;">{{ $item->created_at }}</td>
                                        <td style="vertical-align: top;">{{ $item->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('arsip.form-sk', ['param' => Crypt::encrypt('edit'), 'id' => Crypt::encrypt($item->id)]) }}"
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
                                                action="{{ route('arsip.hapus-sk', ['id' => Crypt::encrypt($item->id)]) }}"
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
