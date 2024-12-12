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
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="m-0">Informasi Aplikasi</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 pt-0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1 text-muted">Aplikasi</p>
                                            <p class="mb-0 fw-bold">{{ env('APP_NAME') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1 text-muted">Deskripsi</p>
                                            <p class="mb-0 fw-bold">{{ env('APP_DESC') }}</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item px-0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1 text-muted">Developer</p>
                                            <p class="mb-0 fw-bold">{{ env('APP_AUTHOR') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1 text-muted">Lisensi Langganan</p>
                                            <p class="mb-0 fw-bold">Pertahun</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item px-0">
                                    <p class="mb-1 text-muted">Keterangan</p>
                                    <p class="mb-0" style="text-align: justify;">
                                        Sistem Informasi Pengawasan Dan Kendali Jadwal Pelaporan (SIWAKJON)
                                        Merupakan Inovasi Dari Pengadilan Negeri Lubuk Pakam. Yang Bertujuan Untuk
                                        Memudahkan Penataan Dokumen Rapat, Pengawasan, Laporan Monitoring dan Evaluasi Serta
                                        Arsip Surat Keputusan Pada Lingkungan Pengadilan Negeri
                                        Lubuk Pakam.
                                    </p>
                                </li>
                                <li class="list-group-item px-0">
                                    <p class="mb-1 text-muted">Serial Number</p>
                                    <p class="mb-0">
                                        {{ Crypt::encrypt(date('d-m-Y')) }}
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <h6 class="mb-0">Release Version</h6>
                                <span class="badge bg-primary ms-2">{{ env('APP_LICENSE') }}</span>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <i class="ph-duotone ph-tag-chevron text-primary f-30"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-inline-flex align-items-center mb-2">
                                        <h6 class="mb-0"><u>V 3.0.0</u></h6>
                                        <span class="badge bg-light-success ms-2">Latest</span>
                                    </div>
                                    <p class="mb-0 text-muted">On {{ now() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0">Butuh Bangun Aplikasi ?</h5>
                        </div>
                        <ul class="list-group list-group-flush border-top-0">
                            <li class="list-group-item">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1 me-2">
                                        <h6 class="mb-0">Contact Me On Instagram</h6>
                                        <p class="my-1"><i class="ti ti-brand-instagram"></i> Just Message, No Call</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="https://wa.me/6281376472224" class="avtar avtar-s btn-link-secondary">
                                            <i class="ti ti-send f-18"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1 me-2">
                                        <h6 class="mb-0">Contact Me On WhatsApp</h6>
                                        <p class="my-1"><i class="ti ti-brand-whatsapp"></i> Just Message, No Call</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="https://www.instagram.com/qori_chairawan17/"
                                            class="avtar avtar-s btn-link-secondary">
                                            <i class="ti ti-send f-18"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <!-- Patch Update Note -->
            <div class="card feed-card">
                <div class="card-header">
                    <h5>Patch Note</h5>
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
                                            <ul class="list-group list-group-flush acc-feeds-list">
                                                <li class="list-group-item p-0 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4 feed-title">
                                                            <p class="mb-1 text-muted">Version 3.0.0</p>
                                                            <small class="mb-0">{{ now() }}</small>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1 text-muted">Perform task related to
                                                                project manager with the 100+
                                                                team
                                                                under my
                                                                observation. Team management is key
                                                                role in this company.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item p-0 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4 feed-title">
                                                            <p class="mb-1 text-muted">Version 3.0.0</p>
                                                            <p class="mb-0">{{ now() }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1 text-muted">Perform task related to
                                                                project manager with the 100+
                                                                team
                                                                under my
                                                                observation. Team management is key
                                                                role in this company.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
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
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
