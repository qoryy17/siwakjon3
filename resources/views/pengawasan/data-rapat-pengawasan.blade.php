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
                        membuat di
                        sistem !
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <a href="" class="btn btn-primary btn-sm"><i class="ph-duotone ph-file-plus"></i>
                        Tambah</a>
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
                                        <a href="#" class="avtar avtar-xs btn-link-secondary">
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
@endsection
