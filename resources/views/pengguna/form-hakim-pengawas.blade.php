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
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h3 class="m-0">{{ $formTitle }}</h3>
                    <a href="{{ route('pengguna.hakim-pengawas') }}">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengguna.simpan-hakim-pengawas') }}" method="POST">
                        @csrf
                        @method('POST')
                        @if (Crypt::decrypt($paramOutgoing) == 'update')
                            <div class="mb-3" hidden>
                                <input type="text" class="form-control" readonly name="id"
                                    value="{{ Crypt::encrypt($hakim->id) }}">
                            </div>
                        @endif
                        <div class="mb-3" hidden>
                            <input type="text" class="form-control" name="param" readonly value="{{ $paramOutgoing }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pegawai">Hakim Pengawas
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" data-trigger name="pegawai" id="pegawai" required>
                                <option value="">Pilih Hakim</option>
                                @foreach ($hakimPengawas as $itemKimWas)
                                    <option value="{{ $itemKimWas->id }}"
                                        @if (old('pegawai') == $itemKimWas->id) selected  @elseif ($hakim && $hakim->pegawai_id == $itemKimWas->id) selected @endif>
                                        {{ $itemKimWas->nama }}</option>
                                @endforeach
                            </select>
                            @error('pegawai')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="unitKerja">Unit Pengawasan
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" required data-trigger name="unitKerja" id="unitKerja">
                                <option value="">Pilih Unit Pengawasan</option>
                                @foreach ($unitKerja as $itemUnitKerja)
                                    <option value="{{ $itemUnitKerja->id }}"
                                        @if (old('unitKerja') == $itemUnitKerja->id) selected @elseif ($hakim && $hakim->unit_kerja_id == $itemUnitKerja->id) selected @endif>
                                        {{ $itemUnitKerja->unit_kerja }}
                                    </option>
                                @endforeach
                            </select>
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
                                <option value="1"
                                    @if (old('aktif') == 'Y') selected @elseif ($hakim && $hakim->aktif == 'Y') selected @endif>
                                    Aktif</option>
                                <option value="T"
                                    @if (old('aktif') == 'T') selected @elseif ($hakim && $hakim->aktif == 'T') selected @endif>
                                    Non Aktif</option>
                            </select>
                            @error('aktif')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="ordering">Ordering
                                <span class="text-danger">*</span>
                            </label>
                            <input type="number" id="ordering" name="ordering" class="form-control" required
                                placeholder="Ordering..." value="{{ $hakim ? $hakim->ordering : old('ordering') }}"
                                min="1">
                            @error('ordering')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                Simpan
                            </button>
                            <button type="reset" class="btn btn-sm btn-secondary"><i class="fas fa-recycle"></i>
                                Batal
                            </button>
                            <a href="{{ route('pengguna.hakim-pengawas') }}" class="btn btn-sm btn-warning">
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
