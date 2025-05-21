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
                            <p class="text-muted text-sm mt-3 m-0">Periode
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
                            <p class="text-muted text-sm mt-3 m-0">Periode
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
                            <p class="text-muted text-sm mt-3 m-0">Periode
                                {{ \App\Helpers\TimeSession::convertMonthIndonesian(date('Y-m-d')) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-sm-12">
                    @if ($pengawasTercepat != null)
                        @if ($pengawasTercepat->exists())
                            @php
                                $hakim = json_decode($pengawasTercepat->first()->hakim_pengawas);
                            @endphp
                            @foreach ($hakim as $pengawas)
                                <div class="card">
                                    <div class="card-body position-relative">
                                        <div class="text-center mt-3">
                                            <div class="chat-avtar d-inline-flex mx-auto">
                                                <img class="rounded-circle img-fluid wid-90 img-thumbnail"
                                                    src="{{ asset('assets/images/badge.png') }}" alt="Badge">
                                                <i class="chat-badge bg-danger me-2 mb-2"></i>
                                            </div>
                                            <h5 class="mb-0">
                                                {{ $pengawas->nama }} <br>
                                                Hakim Pengawas
                                                {{ $pengawasTercepat->first()->objek_pengawasan }}
                                            </h5>
                                            <p class="text-muted mt-1 text-sm m-0">Pengawasan Tercepat Bulan Ini 😍</p>
                                            <small class="text-secondary">Waktu Penyelesaian :
                                                {{ $pengawasTercepat->first()->created_at }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @else
                        <div class="card">
                            <div class="card-body">
                                <p class="text-center">
                                    Belum ada pengawasan tercepat...!!!
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-8 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Agenda Monev Terbaru</h5>
                        </div>
                        <div class="card-body px-0 py-2">
                            <ul class="list-group list-group-flush">
                                @if ($monev->exists())
                                    @foreach ($monev->get() as $itemMonev)
                                        @php
                                            $dibuat = \App\Models\User::findOrFail($itemMonev->dibuat);
                                        @endphp
                                        <li class="list-group-item">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 mx-3">
                                                    {{ $itemMonev->nama_agenda }} <br>
                                                    <small class="text-success">Dibuat oleh : {{ $dibuat->name }} |
                                                        {{ $itemMonev->created_at }}</small>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="list-group-item">
                                        <p>
                                            Belum ada agenda monev terbaru...!!!
                                        </p>
                                    </li>
                                @endif
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
                                                    @if ($agendaRapat->exists())
                                                        @foreach ($agendaRapat->get() as $agenda)
                                                            <div class="row align-items-center m-b-30">
                                                                <div class="col-auto p-r-0">
                                                                    <i
                                                                        class="feather icon-bell bg-light-primary feed-icon text-primary"></i>
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
    <script>
        window.onload = function() {
            let modal = new bootstrap.Modal(document.getElementById('modalNotification'), {
                keyboard: false
            });
            modal.show();
        }
    </script>
@endsection
