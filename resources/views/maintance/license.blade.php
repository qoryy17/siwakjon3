<!DOCTYPE html>
<!-- [Head] start -->
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

    <!-- [ Main Content ] start -->
    <div class="auth-main v1">
        <div class="auth-wrapper">
            <div class="auth-form">
                <div class="container">
                    <div class="card-body soon-card">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-lg-5 text-center">
                                <img class="img-fluid" style="max-width: 300px;" src="{{ asset('siwakjon2.png') }}"
                                    alt="img">
                            </div>
                            <div class="col-lg-7">
                                <div class="text-center">
                                    <h1 class="mt-2">{{ $title }}</h1>
                                    @if ($status != 'Active')
                                        <p class="mt-2 mb-4 text-muted f-16">
                                            Untuk mengakses kembali aplikasi, silahkan aktivasi kembali lisensi dengan
                                            serial number terbaru !
                                        </p>
                                    @endif
                                </div>
                                <div class="alert @if ($status == 'Active') alert-success @else alert-warning @endif"
                                    role="alert">
                                    {{ $message }}
                                </div>

                                <form action="{{ route('license.save') }}" method="POST">
                                    <div class="row g-3 d-flex align-items-center">
                                        @csrf
                                        @method('POST')
                                        <div class="col">
                                            <label for="license">License Serial Number
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="license" name="license" required
                                                autocomplete="off" class="form-control" placeholder="Serial Number..."
                                                value="{{ $status ? $license->license : '' }}"
                                                @if ($status == 'Active') readonly @endif>
                                        </div>
                                        <div class="col-auto">
                                            <div class="d-grid mt-4">
                                                @if ($status != 'Active')
                                                    <button class="btn btn-primary d-flex align-items-center">
                                                        <i class="ti ti-key me-2"></i> Aktivasi
                                                    </button>
                                                @else
                                                    <a href="{{ route('signin') }}"
                                                        class="btn btn-primary d-flex align-items-center">
                                                        <i class="ti ti-login"></i> Login Aplikasi
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        @error('license')
                                            <small class="text-danger mt-1">{{ $message }}</small>
                                        @enderror
                                        <p>
                                            Butuh lisensi aktivasi aplikasi ? Silahkan hubungi {{ env('APP_AUTHOR') }}
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="{{ asset('assets/js/fonts/custom-font.js') }} "></script>
    <script src="{{ asset('assets/js/pcoded.js') }} "></script>
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
