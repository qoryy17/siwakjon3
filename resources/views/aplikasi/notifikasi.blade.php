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
                                <h2 class="mb-0">Notifikasi</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <!-- Notifikasi -->
            <div class="card feed-card">
                <div class="card-header">
                    <h5>Notifikasi</h5>
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
                                                            <p class="mb-1 text-muted">Developer</p>
                                                            <small class="mb-0">{{ now() }}</small>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1 text-muted">
                                                                Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                                                Ducimus dolorum veritatis, labore reprehenderit tenetur
                                                                nemo! Impedit voluptates dignissimos assumenda illum vero,
                                                                quibusdam deserunt quos nihil est, nisi, minus voluptas
                                                                exercitationem!
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
