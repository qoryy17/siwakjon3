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
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">{{ $welcome }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="card statistics-card-1 overflow-hidden ">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/img-status-4.svg') }}" alt="img"
                                class="img-fluid img-bg">
                            <h5 class="mb-4">Rapat Bulan Ini</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $countRapatBulan }}</h3>
                                <span class="badge bg-light-success ms-2">Dilaksanakan</span>
                            </div>
                            <p class="text-muted text-sm mt-3">Periode
                                {{ \App\Helpers\TimeSession::convertMonthIndonesian(date('Y-m-d')) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card statistics-card-1 overflow-hidden ">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/img-status-4.svg') }}" alt="img"
                                class="img-fluid img-bg">
                            <h5 class="mb-4">Pengawasan Bulan Ini</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $countRapatWasbid }}</h3>
                                <span class="badge bg-light-success ms-2">Dilaksanakan</span>
                            </div>
                            <p class="text-muted text-sm mt-3">Periode
                                {{ \App\Helpers\TimeSession::convertMonthIndonesian(date('Y-m-d')) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card statistics-card-1 overflow-hidden ">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/img-status-4.svg') }}" alt="img"
                                class="img-fluid img-bg">
                            <h5 class="mb-4">Monev Bulan Ini</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $countMonev }}</h3>
                                <span class="badge bg-light-success ms-2">Dilaksanakan</span>
                            </div>
                            <p class="text-muted text-sm mt-3">Periode
                                {{ \App\Helpers\TimeSession::convertMonthIndonesian(date('Y-m-d')) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <!-- Agenda Rapat -->
                    <div class="card feed-card">
                        <div class="card-header">
                            <h5>Agenda Rapat Bulan Ini</h5>
                        </div>
                        <div class="latest-scroll simplebar-scrollable-y" style="height:450px;position:relative;"
                            data-simplebar="init">
                            <div class="simplebar-wrapper" style="margin: 0px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                            aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                            <div class="simplebar-content" style="padding: 0px;">
                                                <div class="card-body">
                                                    @if ($agendaRapat->exists())
                                                        @foreach ($agendaRapat->get() as $agenda)
                                                            <div class="row align-items-center m-b-30">
                                                                <div class="col-auto p-r-0">
                                                                    <i
                                                                        class="feather icon-bell bg-light-primary feed-icon text-primary"></i>
                                                                </div>
                                                                <div class="col">
                                                                    <a href="javascript:void(0);">
                                                                        <h6>
                                                                            {{ $agenda->detailRapat->perihal }} <br>
                                                                            <span>Tanggal Rapat :
                                                                                {{ \App\Helpers\TimeSession::convertDateToIndonesian($agenda->detailRapat->tanggal_rapat) }}
                                                                            </span>
                                                                        </h6>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="row align-items-center m-b-30">
                                                            <div class="col-auto p-r-0">
                                                                <i
                                                                    class="feather icon-bell bg-light-warning feed-icon text-warning"></i>
                                                            </div>
                                                            <div class="col">
                                                                <a href="javascript:void(0);">
                                                                    <h6>
                                                                        Belum Ada Agenda Rapat Bulan Ini...
                                                                    </h6>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: 401px; height: 552px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                <div class="simplebar-scrollbar"
                                    style="height: 289px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('rapat.index') }}" class="b-b-primary text-primary">Lihat Semua Agenda
                                Rapat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between py-3">
                            <h5>Pengguna</h5>
                            <div class="dropdown">
                                <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                        class="material-icons-two-tone f-18">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a class="dropdown-item" href="#">Lihat</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-end mb-3">
                                <h4 class="mb-0">{{ $countPengguna }}</h4>
                                <span class="badge bg-light-success ms-2">Telah Terdaftar</span>
                            </div>
                            <p class="text-muted mb-0">Total Seluruh Pengguna {{ env('APP_NAME') }}</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between py-3">
                            <h5>Rapat Tidak Lengkap</h5>
                            <div class="dropdown">
                                <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                        class="material-icons-two-tone f-18">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a class="dropdown-item" href="#">Lihat</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-end mb-3">
                                <h4 class="mb-0">{{ $countRapat }}</h4>
                                <span class="badge bg-light-danger ms-2">Dokumen Tidak Lengkap</span>
                            </div>
                            <p class="text-muted mb-0">Total Seluruh Tunggakan Kelengkapan</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Logs Aktivitas Pengguna</h5>
                        </div>
                        <div class="card-body px-0 py-2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <p>{{ $logs->activity }} </p>
                                    <small class="text-success">Oleh : {{ $logs->user->name }} |
                                        {{ $logs->created_at }}</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
