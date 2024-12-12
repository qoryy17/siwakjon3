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
                            <img src="{{ asset('assets/images/widget/img-status-4.svg') }}" alt="img"
                                class="img-fluid img-bg">
                            <h5 class="mb-4">Rapat Bulan Ini</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">30</h3>
                                <span class="badge bg-light-success ms-2">Dilaksanakan</span>
                            </div>
                            <p class="text-muted text-sm mt-3">Periode Desember</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card statistics-card-1 overflow-hidden ">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/widget/img-status-4.svg') }}" alt="img"
                                class="img-fluid img-bg">
                            <h5 class="mb-4">Pengawasan Bulan Ini</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">30</h3>
                                <span class="badge bg-light-success ms-2">Dilaksanakan</span>
                            </div>
                            <p class="text-muted text-sm mt-3">Periode Desember</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card statistics-card-1 overflow-hidden ">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/widget/img-status-4.svg') }}" alt="img"
                                class="img-fluid img-bg">
                            <h5 class="mb-4">Monev Bulan Ini</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">37</h3>
                                <span class="badge bg-light-success ms-2">Dilaksanakan</span>
                            </div>
                            <p class="text-muted text-sm mt-3">Periode Desember</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-body position-relative">
                            <div class="text-center mt-3">
                                <div class="chat-avtar d-inline-flex mx-auto">
                                    <img class="rounded-circle img-fluid wid-90 img-thumbnail"
                                        src="../assets/images/user/avatar-1.jpg" alt="User image">
                                    <i class="chat-badge bg-danger me-2 mb-2"></i>
                                </div>
                                <h5 class="mb-0">Hakim Pengawas Perdata</h5>
                                <p class="text-muted mt-1 text-sm m-0">Pengawasan Tercepat Bulan Ini 😍</p>
                                <small class="text-secondary">Waktu Penyelesaian : {{ now() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Laporan Monev Diunggah</h5>
                        </div>
                        <div class="card-body px-0 py-2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 mx-3">
                                            Monitoring & Evaluasi Website Periode September <br>
                                            <small class="text-success">Diunggah oleh : Sarah Luksiana Turnip |
                                                {{ now() }}</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="#" class="avtar avtar-s btn-link-secondary">
                                                <i class="ti ti-chevron-right f-20"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 mx-3">
                                            Monitoring & Evaluasi Website Periode September <br>
                                            <small class="text-success">Diunggah oleh : Sarah Luksiana Turnip |
                                                {{ now() }}</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="#" class="avtar avtar-s btn-link-secondary">
                                                <i class="ti ti-chevron-right f-20"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 sm-12">
                    <!-- Agenda Rapat -->
                    <div class="card feed-card">
                        <div class="card-header">
                            <h5>Agenda Rapat Bulan Ini</h5>
                        </div>
                        <div class="latest-scroll simplebar-scrollable-y" style="height:200px;position:relative;"
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
                                                    <div class="row align-items-center m-b-30">
                                                        <div class="col-auto p-r-0">
                                                            <i
                                                                class="feather icon-bell bg-light-primary feed-icon text-primary"></i>
                                                        </div>
                                                        <div class="col">
                                                            <a href="#!">
                                                                <h6>
                                                                    Rapat Kinerja Bulanan Periode Desember <br>
                                                                    <span>Tanggal Rapat : 23-12-2024</span>
                                                                </h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center m-b-30">
                                                        <div class="col-auto p-r-0">
                                                            <i
                                                                class="feather icon-bell bg-light-primary feed-icon text-primary"></i>
                                                        </div>
                                                        <div class="col">
                                                            <a href="#!">
                                                                <h6>
                                                                    Rapat Pengawasan Bidang Kepaniteraan Perdata <br>
                                                                    <span>Tanggal Rapat : 23-12-2024</span>
                                                                </h6>
                                                            </a>
                                                        </div>
                                                    </div>
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
                            <a href="#!" class="b-b-primary text-primary">Lihat Semua Agenda Rapat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 sm-12">
                    <!-- Informasi Pengembang -->
                    <div class="card feed-card">
                        <div class="card-header">
                            <h5>Informasi Pengembang Aplikasi</h5>
                        </div>
                        <div class="latest-scroll simplebar-scrollable-y" style="height:200px;position:relative;"
                            data-simplebar="init">
                            <div class="simplebar-wrapper" style="margin: 0px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                            aria-label="scrollable content"
                                            style="height: 100%; overflow: hidden scroll;">
                                            <div class="simplebar-content" style="padding: 0px;">
                                                <div class="card-body">
                                                    <div class="row align-items-center m-b-30">
                                                        <div class="col-auto p-r-0">
                                                            <i
                                                                class="feather icon-bell bg-light-primary feed-icon text-primary"></i>
                                                        </div>
                                                        <div class="col">
                                                            <a href="#!">
                                                                <h6>
                                                                    Rapat Kinerja Bulanan Periode Desember <br>
                                                                    <span>Tanggal Rapat : 23-12-2024</span>
                                                                </h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center m-b-30">
                                                        <div class="col-auto p-r-0">
                                                            <i
                                                                class="feather icon-bell bg-light-primary feed-icon text-primary"></i>
                                                        </div>
                                                        <div class="col">
                                                            <a href="#!">
                                                                <h6>
                                                                    Rapat Pengawasan Bidang Kepaniteraan Perdata <br>
                                                                    <span>Tanggal Rapat : 23-12-2024</span>
                                                                </h6>
                                                            </a>
                                                        </div>
                                                    </div>
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
                            <a href="#!" class="b-b-primary text-primary">Lihat Semua Agenda Rapat</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
