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
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Perhatian !</strong> Harap mengisi kunjungan pengawasan oleh hakim pengawas bidang setiap
                        bulan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <a href="{{ route('kunjungan.form-kunjungan', ['param' => Crypt::encrypt('add'), 'id' => 'null']) }}"
                        class="btn btn-primary btn-sm">
                        <i class="ph-duotone ph-file-plus"></i> Tambah
                    </a>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Kode Kunjungan</th>
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
                                <tr>
                                    <td>1</td>
                                    <td>{{ Str::uuid() }}</td>
                                    <td>Kepaniteraan Hukum</td>
                                    <td>Belum tersedia...</td>
                                    <td>Qori Chairawan</td>
                                    <td>{{ now() }}</td>
                                    <td>{{ now() }}</td>
                                    <td>
                                        <a href="{{ route('kunjungan.detail', ['id' => 'null']) }}"
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
@endsection
