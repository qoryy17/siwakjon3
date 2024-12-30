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
                        <form action="{{ route('auth.signin') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" placeholder="Email..."
                                    required value="{{ old('email') }}" name="email">
                                @error('email')
                                    <small class="text-danger mt-2">* {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" placeholder="Password..."
                                    required value="{{ old('password') }}" name="password">
                                @error('password')
                                    <small class="text-danger mt-2">* {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                        <div class="saprator my-1">
                            <span>Belum punya akun ?</span>
                        </div>
                        <div class="text-center">
                            Hubungi Superadmin <br> {{ env('APP_AUTHOR') }}
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
