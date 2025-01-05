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

            <div class="card bg-primary">
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

            <form action="{{ route('pengawasan.daftar-hakim-pengawas') }}" method="GET">
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                            <select name="" id="" class="form-control">
                                <option value="">Pilih Objek/Unit Pengawasan</option>
                            </select>
                            <select name="" id="" class="form-control">
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

            <div class="row">
                <div class="col-lg-8">
                    <!-- Result Chart -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-0">Grafik Pelaksaaan Pengawasan</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-1">
                                <h3 class="mb-0">40<small class="text-muted">/ Tahun 2025</small></h3>
                            </div>
                            <p>Total Temuan Pengawasan Bidang Pada Kepaniteraan Hukum</p>
                            <div id="customer-rate-graph"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5>Statistik Pengawasan Tahun {{ date('Y') }}</h5>
                            <i class="ph-duotone ph-info f-20 ms-1" data-bs-toggle="tooltip" data-bs-title="Overview"></i>
                        </div>
                        <div class="card-body">
                            <div id="overview-bar-chart"></div>
                            <div class="bg-body mt-3 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                                <p class="mb-0"><i class="ph-duotone ph-circle text-danger f-12"></i> Total Temuan</p>
                                <h5 class="mb-0 ms-1">Kepaniteraan Hukum</h5>
                            </div>
                            <div class="bg-body mt-3 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                                <p class="mb-0"><i class="ph-duotone ph-circle text-danger f-12"></i> Total Temuan</p>
                                <h5 class="mb-0 ms-1">Kepaniteraan Pidana</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>
                        Temuan Pengawasan Bidang Kepaniteraan Hukum
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
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    @php
        $data = [
            'barChart' => ['unitKerja' => ['Kepaniteraan Hukum', 'Kepaniteraan Pidana'], 'value' => [10, 40, 50, 30]],
            'lineChart' => ['tahun' => [2024, 2025], 'value' => [10, 40]],
        ];
    @endphp
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/w-chart.js') }}"></script> --}}
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
                        height: 230,
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
                        enabled: false
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
                        data: [30, 60, 40, 70, 50, 90, 50, 55, 45, 60, 50, 65]
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
                    }
                };
                var chart = new ApexCharts(document.querySelector('#customer-rate-graph'), options);
                chart.render();

                // overview bar chart
                var options_overview_bar = {
                    chart: {
                        type: 'bar',
                        height: 150,
                        sparkline: {
                            enabled: true
                        }
                    },
                    colors: ['#F44236', '#04A9F5', '#673ab7', '#1DE9B6', '#F4C22B', '#3EBFEA'],
                    plotOptions: {
                        bar: {
                            borderRadius: 2,
                            columnWidth: '80%',
                            distributed: true
                        }
                    },
                    series: [{
                        data: {{ json_encode($data['barChart']['value']) }}
                    }],
                    xaxis: {
                        crosshairs: {
                            width: 1
                        }
                    },
                    tooltip: {
                        fixed: {
                            enabled: false
                        },
                        x: {
                            show: false
                        },
                        y: {
                            title: {
                                formatter: function(seriesName) {
                                    return '';
                                }
                            }
                        },
                        marker: {
                            show: false
                        }
                    }
                };
                var chart_overview_bar = new ApexCharts(document.querySelector('#overview-bar-chart'),
                    options_overview_bar);
                chart_overview_bar.render();


                document.querySelector('#chart-bar').addEventListener('click', function(e) {
                    chart_reports.updateOptions({
                        chart: {
                            type: 'bar',
                        },
                        fill: {
                            type: 'solid',
                        },
                    })
                })

            })();

        }
    </script>
@endsection
