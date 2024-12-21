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
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h3 class="m-0">Detail Rapat</h3>
                    <a href="{{ route('rapat.index') }}">Kembali</a>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 pt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Nomor Rapat</p>
                                    <p class="mb-0 fw-bold">
                                        {{ $rapat->nomor_dokumen }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">TimeStamp</p>
                                    <p class="mb-0 fw-bold">
                                        Created At : {{ $rapat->created_at }}
                                        Last Updated : {{ $rapat->updated_at }}
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Perihal Rapat</p>
                                    <p class="mb-0 fw-bold">
                                        {{ $rapat->detailRapat->perihal }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Klasifikasi Rapat</p>
                                    <p class="mb-0 fw-bold">
                                        {{ $rapat->klasifikasiRapat->rapat }}
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Tanggal Rapat</p>
                                    <p class="mb-0 fw-bold">
                                        {{ Carbon\Carbon::createFromFormat('Y-m-d', $rapat->detailRapat->tanggal_rapat)->format('d-m-Y') }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Waktu Rapat</p>
                                    <p class="mb-0 fw-bold">
                                        {{ $rapat->detailRapat->jam_mulai }} @if ($rapat->detailRapat->jam_selesai != null)
                                            selesai {{ $rapat->detailRapat->jam_selesai }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <p class="mb-1 text-muted">Acara</p>
                            <p class="mb-0" style="text-align: justify;">
                                {!! $rapat->detailRapat->acara !!}
                            </p>
                        </li>
                        <li class="list-group-item px-0">
                            <p class="mb-1 text-muted">Agenda</p>
                            <p class="mb-0" style="text-align: justify;">
                                {!! $rapat->detailRapat->agenda !!}
                            </p>
                        </li>
                        <li class="list-group-item px-0">
                            <p class="mb-1 text-muted">Tempat</p>
                            <p class="mb-0" style="text-align: justify;">
                                {{ $rapat->detailRapat->tempat }}
                            </p>
                        </li>
                        <li class="list-group-item px-0">
                            <p class="mb-1 text-muted">Peserta</p>
                            <p class="mb-0" style="text-align: justify;">
                                {{ $rapat->detailRapat->peserta }}
                            </p>
                        </li>
                        @if (Auth::user()->roles != 'User' || Auth::user()->id == $rapat->dibuat)
                            <li class="list-group-item px-0">
                                <p class="mb-1 text-muted">Kelola Dokumen</p>
                                <a class="btn btn-sm btn-primary"
                                    href="{{ route('rapat.form-undangan', ['param' => Crypt::encrypt('edit'), 'id' => Crypt::encrypt($rapat->id)]) }}">
                                    <i class="fas fa-pencil-alt"></i> Edit Undangan
                                </a>
                                <a class="btn btn-sm btn-primary"
                                    href="{{ route('rapat.form-notula', ['param' => Crypt::encrypt('add'), 'id' => 'null']) }}">
                                    <i class="fas fa-file-word"></i> Tambah Notula
                                </a>
                                <a class="btn btn-sm btn-primary"
                                    href="{{ route('rapat.form-dokumentasi', ['id' => 'null']) }}">
                                    <i class="fas fa-camera"></i> Tambah Dokumentasi
                                </a>
                            </li>
                        @endif

                        <li class="list-group-item px-0">
                            <p class="mb-1 text-muted">Cetak Dokumen</p>
                            <a target="_blank" class="btn btn-sm btn-warning"
                                href="{{ route('rapat.print-undangan', ['id' => Crypt::encrypt($rapat->id)]) }}">
                                <i class="fas fa-file-pdf"></i> Undangan
                            </a>
                            <a target="_blank" class="btn btn-sm btn-warning"
                                href="{{ route('rapat.print-daftar-hadir', ['id' => Crypt::encrypt($rapat->id)]) }}">
                                <i class="fas fa-file-pdf"></i> Daftar Hadir
                            </a>
                            <a target="_blank" class="btn btn-sm btn-warning"
                                href="{{ route('rapat.print-notula', ['id' => Crypt::encrypt($rapat->id)]) }}">
                                <i class="fas fa-file-pdf"></i> Notula
                            </a>
                            <a target="_blank" class="btn btn-sm btn-warning"
                                href="{{ route('rapat.print-dokumentasi', ['id' => Crypt::encrypt($rapat->id)]) }}">
                                <i class="fas fa-file-pdf"></i> Dokumentasi
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
