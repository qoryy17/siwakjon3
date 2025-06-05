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
                                    <li class="breadcrumb-item">
                                        <a href="{{ $bc['link'] }}"{{ $bc['page'] }}>{{ $bc['title'] }}</a>
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
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h3 class="m-0">{{ $formTitle }}</h3>
                    <a href="{{ route('unitKerja.index') }}">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('unitKerja.simpan') }}" method="POST">
                        @csrf
                        @method('POST')
                        @if (Crypt::decrypt($paramOutgoing) == 'update')
                            <div class="mb-3" hidden>
                                <input type="text" class="form-control" readonly name="id"
                                    value="{{ Crypt::encrypt($unitKerja->id) }}">
                            </div>
                        @endif
                        <div class="mb-3" hidden>
                            <input type="text" class="form-control" name="param" readonly value="{{ $paramOutgoing }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="unitKerja">Unit Kerja <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Unit Kerja..." id="unitKerja"
                                maxlength="300" name="unitKerja" required
                                value="{{ $unitKerja ? $unitKerja->unit_kerja : old('unitKerja') }}">
                            @error('unitKerja')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="aktif">Aktif
                                <span class="text-danger">*</span>
                            </label>
                            <select name="aktif" id="aktif" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="Y"
                                    @if (old('aktif') == 'Y') selected @elseif ($unitKerja && $unitKerja->aktif == 'Y') selected @endif>
                                    Aktif</option>
                                <option value="T"
                                    @if (old('aktif') == 'T') selected @elseif ($unitKerja && $unitKerja->aktif == 'T') selected @endif>
                                    Non Aktif</option>
                            </select>
                            @error('aktif')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-sm btn-secondary">
                                <i class="fas fa-recycle"></i> Batal
                            </button>
                            <a href="{{ route('unitKerja.index') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-reply-all"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
