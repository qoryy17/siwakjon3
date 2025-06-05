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
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h3 class="m-0">{{ $formTitle }}</h3>
                    <a href="{{ route('arsip.surat-keputusan') }}">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('arsip.simpan-sk') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        @if (Crypt::decrypt($paramOutgoing) == 'update')
                            <div class="mb-3" hidden>
                                <input type="text" class="form-control" readonly name="id"
                                    value="{{ Crypt::encrypt($arsipSK->id) }}">
                            </div>
                        @endif
                        <div class="mb-3" hidden>
                            <input type="text" class="form-control" name="param" readonly value="{{ $paramOutgoing }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nomor">Nomor
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="nomor" id="nomor" required
                                placeholder="Nomor Surat Keputusan..."
                                value="{{ $arsipSK ? $arsipSK->nomor : old('nomor') }}">
                            @error('nomor')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="judul">Judul
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="judul" id="judul" required
                                placeholder="Judul Surat Keputusan..."
                                value="{{ $arsipSK ? $arsipSK->judul : old('judul') }}">
                            @error('judul')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tanggalTerbit">Tanggal Terbit
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="tanggalTerbit" id="tanggalTerbit"
                                placeholder="Pilih Tanggal Terbit" readonly required
                                value="{{ $arsipSK ? Carbon\Carbon::createFromFormat('Y-m-d', $arsipSK->tanggal_terbit)->format('m/d/Y') : old('tanggalTerbit') }}">
                            @error('tanggalTerbit')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-file mb-3">
                            <label class="form-label" for="file">File PDF
                                <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" aria-label="file" id="file" name="file">
                            @error('file')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                            <small class="text-danger mt-1">* Maksimal file pdf ukuran 10 MB</small> <br>
                            @if ($arsipSK)
                                <small class="text-danger mt-1">* Kosongkan jika tidak ingin mengganti</small>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status">Status
                                <span class="text-danger">*</span>
                            </label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="Berlaku"
                                    @if (old('status') == 'Berlaku') selected @elseif ($arsipSK && $arsipSK->status == 'Berlaku') selected @endif>
                                    Berlaku</option>
                                <option value="Tidak Berlaku"
                                    @if (old('status') == 'Tidak Berlaku') selected @elseif ($arsipSK && $arsipSK->status == 'Tidak Berlaku') selected @endif>
                                    Tidak Berlaku</option>
                            </select>
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-sm btn-secondary">
                                <i class="fas fa-recycle"></i> Batal
                            </button>
                            <a href="{{ route('arsip.surat-keputusan') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-reply-all"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
    <script type="text/javascript">
        (function() {
            const d_week = new Datepicker(document.querySelector("#tanggalTerbit"), {
                buttonClass: "btn",
            });
        })();
    </script>
@endsection
