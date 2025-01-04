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
            <div class="card">
                <div class="card-header">
                    <h3>Set Kode Rapat</h3>
                    <small>Set Kode Rapat Untuk Rapat Kedinasan dan Rapat Pengawasan</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('klasifikasi.simpan-kode') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label class="form-label" for="KodeRapatDinas">Set Kode Rapat Dinas</label>
                            <select class="form-select" id="KodeRapatDinas" name="rapatDinas">
                                <option value="">Pilih Kode Surat</option>
                                @foreach ($kodeRapat as $item)
                                    <option value="{{ $item->kode_surat }}"
                                        @if ($setKode && $setKode->kode_rapat_dinas == $item->kode_surat) selected @endif>
                                        {{ $item->kode_surat }} |
                                        {{ $item->keterangan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="KodeRapatPengawasan">Set Kode Rapat Pengawasan</label>
                            <select class="form-select" id="KodeRapatPengawasan" name="rapatPengawasan">
                                <option value="">Pilih Kode Surat</option>
                                @foreach ($kodeRapat as $item)
                                    <option value="{{ $item->kode_surat }}"
                                        @if ($setKode && $setKode->kode_pengawasan == $item->kode_surat) selected @endif>
                                        {{ $item->kode_surat }} |
                                        {{ $item->keterangan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
