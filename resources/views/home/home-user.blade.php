@extends('layout.body')
@section('title', env('APP_NAME') . ' | ' . $title)
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
                            <img src="{{ asset('assets/images/img-status-7.svg') }}" alt="img"
                                class="img-fluid img-bg">
                            <h5 class="mb-4">Rapat Bulan Ini</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $countRapatBulan }}</h3>
                                <span class="badge bg-light-success ms-2">Dilaksanakan</span>
                            </div>
                            <p class="text-muted text-sm mt-3 m-0">Periode
                                {{ \App\Helpers\TimeSession::convertMonthIndonesian(date('Y-m-d')) }} {{ date('Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card statistics-card-1 overflow-hidden ">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/img-status-7.svg') }}" alt="img"
                                class="img-fluid img-bg">
                            <h5 class="mb-4">Pengawasan Bulan Ini</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $countRapatWasbid }}</h3>
                                <span class="badge bg-light-success ms-2">Dilaksanakan</span>
                            </div>
                            <p class="text-muted text-sm mt-3 m-0">Periode
                                {{ \App\Helpers\TimeSession::convertMonthIndonesian(date('Y-m-d')) }} {{ date('Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card statistics-card-1 overflow-hidden ">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/img-status-7.svg') }}" alt="img"
                                class="img-fluid img-bg">
                            <h5 class="mb-4">Monev Bulan Ini</h5>
                            <div class="d-flex align-items-center mt-3">
                                <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $countMonev }}</h3>
                                <span class="badge bg-light-success ms-2">Dilaksanakan</span>
                            </div>
                            <p class="text-muted text-sm mt-3 m-0">Periode
                                {{ \App\Helpers\TimeSession::convertMonthIndonesian(date('Y-m-d')) }} {{ date('Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">Rapat Dibuat Oleh Kamu</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Agenda Rapat</th>
                                    <th>Tanggal Rapat</th>
                                    <th>Kategori</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($rapatUser->exists())
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($rapatUser->get() as $rapat)
                                        @php
                                            $getDokumentasi = \App\Models\Manajemen\DokumentasiRapatModel::where(
                                                'detail_rapat_id',
                                                '=',
                                                $rapat->detailRapat->id,
                                            )->first();

                                            if ($rapat->klasifikasiRapat->rapat == 'Pengawasan') {
                                                // Search pengawasan
                                                $pengawasan = \App\Models\Manajemen\PengawasanBidangModel::where(
                                                    'detail_rapat_id',
                                                    '=',
                                                    $rapat->detailRapat->id,
                                                )->first();

                                                if ($pengawasan) {
                                                    $getEdoc = \App\Models\Manajemen\EdocWasbidModel::where(
                                                        'pengawasan_bidang_id',
                                                        '=',
                                                        $pengawasan->id,
                                                    )->first();
                                                } else {
                                                    $getEdoc = false;
                                                }
                                            } else {
                                                $getEdoc = \App\Models\Manajemen\EdocRapatModel::where(
                                                    'detail_rapat_id',
                                                    '=',
                                                    $rapat->detailRapat->id,
                                                )->first();
                                            }
                                        @endphp
                                        <tr>
                                            <td>
                                                {{ $no }}
                                            </td>
                                            <td>
                                                {{ $rapat->detailRapat->perihal }}
                                            </td>
                                            <td>
                                                {{ \App\Helpers\TimeSession::convertDateToIndonesian($rapat->detailRapat->tanggal_rapat) }}
                                            </td>
                                            <td>
                                                {{ $rapat->klasifikasiRapat->rapat }}
                                            </td>
                                            <td>
                                                @if ($rapat->detailRapat->notulen == null)
                                                    <span class="badge bg-danger">
                                                        Notulen belum dilengkapi !
                                                    </span>
                                                @elseif (!$getDokumentasi)
                                                    <span class="badge bg-danger">
                                                        Dokumentasi belum dilengkapi !
                                                    </span>
                                                @elseif (!$getEdoc)
                                                    <span class="badge bg-danger">
                                                        Edoc PDF belum dilengkapi !
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        Dokumen lengkap !
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($rapat->klasifikasiRapat->rapat == 'Pengawasan')
                                                    <a href="{{ route('pengawasan.detail', ['id' => Crypt::encrypt($rapat->id)]) }}"
                                                        class="avtar avtar-xs btn-link-secondary">
                                                        <i class="ti ti-eye f-20"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('rapat.detail', ['id' => Crypt::encrypt($rapat->id)]) }}"
                                                        class="avtar avtar-xs btn-link-secondary">
                                                        <i class="ti ti-eye f-20"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
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
                        <div class="latest-scroll simplebar-scrollable-y" style="height:278px; position:relative;"
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
                                                                        class="feather icon-bell bg-light-primary feed-icon text-primary">
                                                                    </i>
                                                                </div>
                                                                <div class="col">
                                                                    @if ($agenda->klasifikasiRapat->rapat == 'Pengawasan')
                                                                        <a title="Rapat {{ $agenda->perihal }}"
                                                                            href="{{ route('pengawasan.detail', ['id' => Crypt::encrypt($agenda->id)]) }}">
                                                                            <h6>
                                                                                {{ $agenda->detailRapat->perihal }} <br>
                                                                                <span>Tanggal Rapat :
                                                                                    {{ \App\Helpers\TimeSession::convertDateToIndonesian($agenda->detailRapat->tanggal_rapat) }}
                                                                                </span>
                                                                            </h6>
                                                                        </a>
                                                                    @else
                                                                        <a title="Rapat {{ $agenda->perihal }}"
                                                                            href="{{ route('rapat.detail', ['id' => Crypt::encrypt($agenda->id)]) }}">
                                                                            <h6>
                                                                                {{ $agenda->detailRapat->perihal }} <br>
                                                                                <span>Tanggal Rapat :
                                                                                    {{ \App\Helpers\TimeSession::convertDateToIndonesian($agenda->detailRapat->tanggal_rapat) }}
                                                                                </span>
                                                                            </h6>
                                                                        </a>
                                                                    @endif
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
                                <div class="simplebar-placeholder" style="width: 400px; height: 552px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                <div class="simplebar-scrollbar"
                                    style="height: 300px; transform: translate3d(0px, 0px, 0px); display: block;">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('rapat.index') }}" class="b-b-primary text-primary">
                                Lihat Semua Agenda Rapat
                            </a>
                        </div>
                    </div>

                    <!-- Informasi Pengembang -->
                    <div class="card feed-card">
                        <div class="card-header">
                            <h5>Informasi Pengembang Aplikasi</h5>
                        </div>
                        <div class="latest-scroll simplebar-scrollable-y" style="height:278px; position:relative;"
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
                                                    @if ($informasi->exists())
                                                        @foreach ($informasi->get() as $pengembang)
                                                            <div class="row align-items-center m-b-30">
                                                                <div class="col-auto p-r-0" style="vertical-align: top;">
                                                                    <i
                                                                        class="feather icon-bell bg-light-primary feed-icon text-primary"></i>
                                                                </div>
                                                                <div class="col">
                                                                    <a href="javascript:void(0);">
                                                                        <h6 style="line-height: 1.5; font-weight: normal;">
                                                                            {{ $pengembang->catatan }} <br>
                                                                            <span>Published:
                                                                                {{ $pengembang->created_at }}
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
                                                                        Belum Ada Informasi Pengembangan Aplikasi...
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
                                <div class="simplebar-placeholder" style="width: 400px; height: 552px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                <div class="simplebar-scrollbar"
                                    style="height: 300px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 sm-12">
                    <!-- Statistik Rapat -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Statistik Rapat Tahun {{ date('Y') }}</h5>
                        </div>
                        <div class="card-body">
                            <div id="statistik-rapat"></div>
                        </div>
                    </div>

                    <!-- Carousel Hakim Pengawas -->
                    @include('home.carousel-kimwas')
                </div>
            </div>
            <!-- Modal Notification -->
            <div id="modalNotification" class="modal fade" tabindex="-1" role="dialog"
                aria-labelledby="modalNotificationTitle" aria-hidden="true">
                <x-modal.modal-notification />
            </div>
            <!-- End Modal Notification -->
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script>
        // [ statistik-rapat ] start
        (function() {
            var options = {
                chart: {
                    height: 297,
                    type: 'pie',
                },
                series: [{{ $statistikRapat['bulanan'] }}, {{ $statistikRapat['berjenjang'] }},
                    {{ $statistikRapat['lainnya'] }}, {{ $statistikRapat['pengawasan'] }}
                ],
                labels: ["Bulanan", "Berjenjang", "Lainnya", "Pengawasan"],
                legend: {
                    show: true,
                    offsetY: 50,
                },
                theme: {
                    monochrome: {
                        enabled: false,
                        color: '#1DE9B6',
                    }
                },
                responsive: [{
                    breakpoint: 600,
                    options: {
                        chart: {
                            height: 300,

                        },
                        legend: {
                            position: 'bottom',
                            offsetY: 0,
                        }
                    }
                }]
            }
            var chart = new ApexCharts(document.querySelector("#statistik-rapat"), options);
            chart.render();
        })();
        // [ statistik-rapat ] end
        window.onload = function() {
            if (!localStorage.getItem('modalNotificationShown')) {
                let modal = new bootstrap.Modal(document.getElementById('modalNotification'), {
                    keyboard: false
                });
                modal.show();
                localStorage.setItem('modalNotificationShown', 'true');
            }
        }
    </script>
@endsection
