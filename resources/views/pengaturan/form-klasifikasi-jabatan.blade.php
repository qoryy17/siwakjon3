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
                    <a href="{{ route('klasifikasi.index', ['param' => 'jabatan']) }}">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label class="form-label" for="jabatan">Jabatan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="jabatan" placeholder="Jabatan..."
                                id="jabatan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kodeJabatan">Kode Jabatan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="kodeJabatan" placeholder="Kode Jabatan..."
                                id="kodeJabatan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="aktif">Aktif
                                <span class="text-danger">*</span>
                            </label>
                            <select name="aktif" id="aktif" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="Y">Aktif</option>
                                <option value="T">Non Aktif</option>
                            </select>
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                Simpan</button>
                            <button type="reset" class="btn btn-sm btn-secondary"><i class="fas fa-recycle"></i>
                                Batal</button>
                            <a href="{{ route('klasifikasi.index', ['param' => 'jabatan']) }}"
                                class="btn btn-sm btn-warning">
                                <i class="fas fa-reply"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
