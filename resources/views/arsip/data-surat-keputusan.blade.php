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
                    <a href="" class="btn btn-primary btn-sm"><i class="ph-duotone ph-file-plus"></i>
                        Tambah</a>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Nomor</th>
                                    <th>Judul</th>
                                    <th>Tanggal Terbit</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    <th>Diunggah</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-start">1</td>
                                    <td>90/W2.U4/PW1.1/X/2024</td>
                                    <td>SK Pengangkatan Tenaga Ahli</td>
                                    <td>{{ date('d-m-Y') }}</td>
                                    <td>
                                        <a href="" target="_BLANK" class="btn btn-primary btn-sm" title="Lihat ">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </td>
                                    <td>Berlaku</td>
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
