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
                                <h2 class="mb-0">Daftar Hakim Pengawas</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row align-items-center mb-3">
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Cari Hakim Pengawas...">
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" type="button">Cari</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-body position-relative">
                            <div class="text-center mt-3">
                                <div class="chat-avtar d-inline-flex mx-auto">
                                    <img class="rounded-circle img-fluid wid-90 img-thumbnail"
                                        src="{{ asset('assets/images/user.png') }}" alt="User image">
                                    <i class="chat-badge bg-success me-2 mb-2"></i>
                                </div>
                                <h5 class="mb-0">Dewi Andriyani</h5>
                                <p class="text-muted mt-1 text-sm m-0">Hakim Pengawas Kepaniteraa Perdata</p>
                                <small class="text-secondary">Bergabung Sejak : {{ now() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-body position-relative">
                            <div class="text-center mt-3">
                                <div class="chat-avtar d-inline-flex mx-auto">
                                    <img class="rounded-circle img-fluid wid-90 img-thumbnail"
                                        src="{{ asset('assets/images/user.png') }}" alt="User image">
                                    <i class="chat-badge bg-success me-2 mb-2"></i>
                                </div>
                                <h5 class="mb-0">Dewi Andriyani</h5>
                                <p class="text-muted mt-1 text-sm m-0">Hakim Pengawas Kepaniteraa Perdata</p>
                                <small class="text-secondary">Bergabung Sejak : {{ now() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-body position-relative">
                            <div class="text-center mt-3">
                                <div class="chat-avtar d-inline-flex mx-auto">
                                    <img class="rounded-circle img-fluid wid-90 img-thumbnail"
                                        src="{{ asset('assets/images/user.png') }}" alt="User image">
                                    <i class="chat-badge bg-success me-2 mb-2"></i>
                                </div>
                                <h5 class="mb-0">Dewi Andriyani</h5>
                                <p class="text-muted mt-1 text-sm m-0">Hakim Pengawas Kepaniteraa Perdata</p>
                                <small class="text-secondary">Bergabung Sejak : {{ now() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
