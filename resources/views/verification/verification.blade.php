<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $title }}</title>
    <!-- [Meta] -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <x-meta-component />

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('siwakjon2.png') }}" type="image/png" />
    <!-- [Google Font : Public Sans] icon -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-8" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr"
    data-pc-theme="light">
    @if (session()->has('success'))
        <script>
            'use strict';
            window.onload = function() {
                Swal.fire({
                    icon: "success",
                    title: "Notifikasi",
                    text: "{{ session('success') }}"
                });
            }
        </script>
    @elseif (session()->has('error'))
        <script>
            'use strict';
            window.onload = function() {
                Swal.fire({
                    icon: "error",
                    title: "Notifikasi",
                    text: "{{ session('error') }}"
                });
            }
        </script>
    @endif
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <div class="auth-main v1">
        <div class="auth-wrapper">
            @if ($result == null)
                <div class="auth-form">
                    <div class="card my-5">
                        <div class="card-body">
                            <div class="text-center">
                                <img loading="lazy" style="max-width: 100px;" src="{{ asset('siwakjon2.png') }}"
                                    alt="images" class="img-fluid mb-3">
                                <h4 class="f-w-500 mb-1">{{ env('APP_NAME') }}</h4>
                                <p class="mb-3">
                                    {{ env('APP_DESC') }}
                                </p>
                            </div>
                            <form action="{{ route('verification') }}" method="GET">
                                <div class="mb-3">
                                    <label for="search">Pencarian Dokumen <span class="text-danger">*</span></label>
                                    <input type="search" class="form-control mt-2" id="search" autocomplete="off"
                                        placeholder="Masukan Kode Dokumen..." required value="{{ old('search') }}"
                                        name="search">
                                    @error('search')
                                        <small class="text-danger mt-2">* {{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary">Cari Dokumen</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            @if ($result != null)
                <div class="card container my-4">
                    <div class="card-header">
                        <h3 class="m-0">Pencarian Dokumen</h3>
                        <h4 class="mt-1 text-muted">Perihal : {{ $result['rapat']->detailRapat->perihal }}</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 pt-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted">Nomor Rapat</p>
                                        <p class="mb-0 fw-bold">
                                            {{ $result['rapat']->nomor_dokumen }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted">TimeStamp</p>
                                        <p class="mb-0 fw-bold">
                                            Created At : {{ $result['rapat']->created_at }}
                                            Last Updated : {{ $result['rapat']->updated_at }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted">Perihal Rapat</p>
                                        <p class="mb-0 fw-bold">
                                            {{ $result['rapat']->detailRapat->perihal }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted">Klasifikasi Rapat</p>
                                        <p class="mb-0 fw-bold">
                                            {{ $result['rapat']->klasifikasiRapat->rapat }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted">Tanggal Rapat</p>
                                        <p class="mb-0 fw-bold">
                                            {{ Carbon\Carbon::createFromFormat('Y-m-d', $result['rapat']->detailRapat->tanggal_rapat)->format('d-m-Y') }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted">Waktu Rapat</p>
                                        <p class="mb-0 fw-bold">
                                            {{ $result['rapat']->detailRapat->jam_mulai }} @if ($result['rapat']->detailRapat->jam_selesai != null)
                                                selesai {{ $result['rapat']->detailRapat->jam_selesai }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                @php
                                    $dibuat = \App\Models\User::findOrFail($result['rapat']->dibuat);
                                    $disetujui = App\Models\Pengguna\PegawaiModel::findOrFail(
                                        $result['rapat']->pejabat_penandatangan,
                                    );
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted">Dibuat Oleh</p>
                                        <p class="mb-0 fw-bold">
                                            {{ $dibuat->name }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted">Disetujui Oleh</p>
                                        <p class="mb-0 fw-bold">
                                            {{ $disetujui->nama }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <p class="mb-1 text-muted">Acara</p>
                                <p class="mb-0" style="text-align: justify;">
                                    {!! $result['rapat']->detailRapat->acara !!}
                                </p>
                            </li>
                            <li class="list-group-item px-0">
                                <p class="mb-1 text-muted">Agenda</p>
                                <p class="mb-0" style="text-align: justify;">
                                    {!! $result['rapat']->detailRapat->agenda !!}
                                </p>
                            </li>
                            <li class="list-group-item px-0">
                                <p class="mb-1 text-muted">Tempat</p>
                                <p class="mb-0" style="text-align: justify;">
                                    {{ $result['rapat']->detailRapat->tempat }}
                                </p>
                            </li>
                            <li class="list-group-item px-0">
                                <p class="mb-1 text-muted">Peserta</p>
                                <p class="mb-0" style="text-align: justify;">
                                    {{ $result['rapat']->detailRapat->peserta }}
                                </p>
                            </li>
                            @if ($result['pengawasan'] != null)
                                <li class="list-group-item px-0">
                                    <h5>Pengawasan Bidang</h5>
                                </li>
                                <li class="list-group-item px-0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1 text-muted">Kode Pengawasan</p>
                                            <p class="mb-0 fw-bold">
                                                {{ $result['pengawasan']->kode_pengawasan }}
                                            </p>
                                            <p class="text-muted">
                                                Objek Pengawasan :
                                                <strong>{{ $result['pengawasan']->objek_pengawasan }}</strong>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-0 fw-bold">
                                                Hakim Pengawas
                                            </p>
                                            @php
                                                $hakim = json_decode($result['pengawasan']->hakim_pengawas);
                                            @endphp
                                            <ul>
                                                @foreach ($hakim as $pengawas)
                                                    <li style="font-weight: 800;">
                                                        {{ $pengawas->nama }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            <li class="list-group-item px-0">
                                <a href="{{ route('verification') }}" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                    Cari Ulang...
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
            <div class="auth-sidefooter">
                <div class="row">
                    <div class="col my-1">
                        <p class="m-0">Made by {{ env('APP_AUTHOR') }}
                        </p>
                    </div>
                    <div class="col-auto my-1">
                        <ul class="list-inline footer-link mb-0">
                            <li class="list-inline-item">{{ env('APP_NAME') }}</li>
                            <li class="list-inline-item">
                                {{ env('APP_LICENSE') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script>
        layout_change('light');
    </script>
    <script>
        layout_sidebar_change('light');
    </script>
    <script>
        change_box_container('false');
    </script>
    <script>
        layout_caption_change('true');
    </script>
    <script>
        layout_rtl_change('false');
    </script>
    <script>
        preset_change("preset-8");
    </script>
    <script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
</body>
<!-- [Body] end -->

</html>
