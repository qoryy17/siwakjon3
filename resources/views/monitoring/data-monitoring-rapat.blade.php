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
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="card">
                <div class="card-header">
                    <h3>Monitoring Kelengkapan Dokumen Rapat</h3>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Nomor Rapat</th>
                                    <th>Perihal</th>
                                    <th class="text-start">Tanggal Rapat</th>
                                    <th>Klasifikasi</th>
                                    <th>Keterangan</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($rapat as $item)
                                    @php
                                        $dibuat = \App\Models\User::find($item->dibuat);
                                        $edoc = App\Models\Manajemen\EdocRapatModel::where(
                                            'detail_rapat_id',
                                            $item->detailRapat->id,
                                        )->first();

                                        $getDokumentasi = \App\Models\Manajemen\DokumentasiRapatModel::where(
                                            'detail_rapat_id',
                                            '=',
                                            $item->detailRapat->id,
                                        )->first();

                                        if ($item->klasifikasiRapat->rapat == 'Pengawasan') {
                                            // Search pengawasan
                                            $pengawasan = \App\Models\Manajemen\PengawasanBidangModel::where(
                                                'detail_rapat_id',
                                                '=',
                                                $item->detailRapat->id,
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
                                                $item->detailRapat->id,
                                            )->first();
                                        }
                                    @endphp
                                    <tr>
                                        <td style="vertical-align: top;" class="text-start">{{ $no }}</td>
                                        <td style="vertical-align: top;" class="text-start">{{ $item->nomor_dokumen }}</td>
                                        <td style="vertical-align: top; text-wrap: wrap;">{{ $item->detailRapat->perihal }}
                                        </td>
                                        <td style="vertical-align: top;" class="text-start">
                                            {{ \App\Helpers\TimeSession::convertDateToIndonesian($item->detailRapat->tanggal_rapat) }}
                                        </td>
                                        <td style="vertical-align: top;">
                                            {{ $item->klasifikasiRapat->rapat }}
                                        </td>
                                        <td style="vertical-align: top;">
                                            @if ($item->detailRapat->disahkan == null)
                                                <span class="badge bg-danger">Belum Ada Notula</span>
                                            @elseif (!$getDokumentasi)
                                                <span class="badge bg-danger">Belum Ada Dokumentasi</span>
                                            @elseif (!$getEdoc)
                                                <span class="badge bg-danger">Belum Unggah Edoc</span>
                                            @else
                                                <span class="badge bg-success">Lengkap</span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: top;">{{ $dibuat->name }}</td>
                                        <td style="vertical-align: top;">{{ $item->created_at }}</td>
                                        <td style="vertical-align: top;">{{ $item->updated_at }}</td>
                                        <td style="vertical-align: top;">
                                            @if ($item->klasifikasiRapat->rapat == 'Pengawasan')
                                                <a href="{{ route('pengawasan.detail', ['id' => Crypt::encrypt($item->id)]) }}"
                                                    class="avtar avtar-xs btn-link-secondary">
                                                    <i class="ti ti-eye f-20"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('rapat.detail', ['id' => Crypt::encrypt($item->id)]) }}"
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
