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
                                    <li class="breadcrumb-item">
                                        <a href="{{ $bc['link'] }}" {{ $bc['page'] }}>{{ $bc['title'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <h3 class="text-black">Selamat Datang Di Monitoring Pengawasan</h3>
                            <p class="text-black mb-0">
                                Halaman ini dipergunakan untuk memonitoring pelaksanaan pengawasan bidang pada unit
                                kerja yang ada di {{ $aplikasi->satuan_kerja }}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <img src="{{ asset('siwakjon2.png') }}" alt="img" class="img-fluid wid-80">
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('monitoring.index') }}" method="GET">
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                            <select required class="form-control" name="search">
                                <option value="">Pilih Objek/Unit Pengawasan</option>
                                @foreach ($objekPengawasan as $item)
                                    <option value="{{ $item->unit_kerja }}">{{ $item->unit_kerja }}</option>
                                @endforeach
                            </select>
                            <select name="tahun" required class="form-control">
                                <option value="">Pilih Tahun</option>
                                @for ($i = 0; $i < 5; $i++)
                                    <option value="{{ date('Y') + $i }}">{{ date('Y') + $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" type="button">Cari</button>
                    </div>
                </div>
            </form>

            @if ($result != null)
                @if ($result != 'Not Found')
                    <!-- Result Chart -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-0">Grafik Pelaksaaan Pengawasan</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-1">
                                <h3 class="mb-0">{{ $result['totalTemuan'] }}
                                    <small class="text-muted">/ Tahun {{ $result['tahun'] }}</small>
                                </h3>
                            </div>
                            <p>Total Temuan Pengawasan Bidang Pada {{ $result['objek'] }}</p>
                            <div id="pengawasan-chart"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>
                                Temuan Pengawasan Bidang {{ $result['objek'] }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th width="1%">No</th>
                                            <th>Temuan</th>
                                            <th>Kondisi</th>
                                            <th>Rekomendasi</th>
                                            <th>Waktu Penyelesaian</th>
                                            <th>Tanggal/Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($result['temuan'] as $temuan)
                                            <tr>
                                                <td style="vertical-align: top;">{{ $no }}</td>
                                                <td style="vertical-align: top;">{!! $temuan->judul !!}</td>
                                                <td style="text-wrap: wrap; vertical-align: top;">{!! $temuan->kondisi !!}
                                                </td>
                                                <td style="text-wrap: wrap; vertical-align: top;">
                                                    {!! $temuan->rekomendasi !!}</td>
                                                <td style="vertical-align: top;">{{ $temuan->waktu_penyelesaian }}</td>
                                                <td style="vertical-align: top;">{{ $temuan->created_at }}</td>
                                            </tr>
                                            @php
                                                $no++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('monitoring.index') }}" class="btn btn-primary">
                        <i class="fas fa-recycle"></i> Muat Ulang
                    </a>
                @else
                    <div class="alert alert-warning" role="alert">
                        <p class="m-0">
                            Data yang kamu cari belum tersedia nih. Harap cek secara berkala ya
                        </p>
                    </div>
                    <a href="{{ route('monitoring.index') }}" class="btn btn-primary">
                        <i class="fas fa-recycle"></i> Muat Ulang
                    </a>
                @endif

            @endif

            <!-- [ Main Content ] end -->
        </div>
    </div>
    @if ($result != null && $result != 'Not Found')
        <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
        <script>
            'use strict';
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    floatchart();
                }, 500);
            });

            function floatchart() {

                (function() {
                    var options = {
                        chart: {
                            type: 'area',
                            height: 250,
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#0d6efd'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                type: 'vertical',
                                inverseColors: false,
                                opacityFrom: 0.5,
                                opacityTo: 0
                            }
                        },
                        dataLabels: {
                            enabled: false,
                            formatter: function(val) {
                                return Math.round(val);
                            }
                        },
                        stroke: {
                            width: 1
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '45%',
                                borderRadius: 4
                            }
                        },
                        grid: {
                            strokeDashArray: 4
                        },
                        series: [{
                            data: {{ json_encode($result['barChart']) }}
                        }],
                        xaxis: {
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                                'Dec'
                            ],
                            labels: {
                                hideOverlappingLabels: true,
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return Math.round(val);
                                }
                            }
                        }
                    };
                    var chart = new ApexCharts(document.querySelector('#pengawasan-chart'), options);
                    chart.render();

                })();

            }
        </script>
    @endif

@endsection
