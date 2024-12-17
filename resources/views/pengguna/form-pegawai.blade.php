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
                    <a href="{{ route('pengguna.pegawai') }}">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengguna.simpan-pegawai') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        @if (Crypt::decrypt($paramOutgoing) == 'update')
                            <div class="mb-3" hidden>
                                <input type="text" class="form-control" readonly name="id"
                                    value="{{ Crypt::encrypt($pegawai->id) }}">
                            </div>
                        @endif
                        <div class="mb-3" hidden>
                            <input type="text" class="form-control" name="param" readonly value="{{ $paramOutgoing }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nip">NIP</label>
                            <input type="text" class="form-control" placeholder="NIP..." id="nip" name="nip"
                                value="{{ $pegawai ? $pegawai->nip : old('nip') }}">
                            <small class="text-danger">* Kosongkan jika tidak ada</small>
                            @error('nip')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Lengkap
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" placeholder="Nama Lengkap..." id="nama"
                                name="nama" required value="{{ $pegawai ? $pegawai->nama : old('nama') }}">
                            @error('nama')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jabatan">Jabatan
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" data-trigger name="jabatan" id="jabatan" required>
                                <option value="">Pilih Jabatan</option>
                                @foreach ($jabatan as $item)
                                    <option value="{{ $item->id }}" @if ($pegawai && $pegawai->jabatan_id == $item->id) selected @endif>
                                        {{ $item->jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="aktif">Aktif
                                <span class="text-danger">*</span>
                            </label>
                            <select name="aktif" id="aktif" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="Y"
                                    @if (old('aktif') == 'Y') selected @elseif ($pegawai && $pegawai->aktif == 'Y') selected @endif>
                                    Aktif</option>
                                <option value="T"
                                    @if (old('aktif') == 'T') selected @elseif ($pegawai && $pegawai->aktif == 'T') selected @endif>
                                    Non Aktif</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan...">{{ $pegawai ? $pegawai->keterangan : old('keterangan') }}</textarea>
                            @error('keterangan')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-file mb-3">
                            <label class="form-label" for="foto">Foto</label>
                            <input type="file" class="form-control" aria-label="foto" id="foto" name="foto">
                            <small class="text-danger">* Unggah jika ada, maksimal 5MB</small>
                        </div>
                        <div class="mb-3">
                            <img src="" alt="Pratinjau Gambar" class="img img-thumbnail" id="imgPreview"
                                style="display: none; max-width: 200px;">

                            @if ($pegawai)
                                <img src="{{ $pegawai ? asset('storage/' . $pegawai->foto) : '' }}" alt="Pratinjau Gambar"
                                    class="img img-thumbnail" style="max-width: 200px;">
                            @endif
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-sm btn-secondary">
                                <i class="fas fa-recycle"></i> Batal
                            </button>
                            <a href="{{ route('pengguna.pegawai') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-reply-all"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <script>
        document.getElementById('foto').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const imgPreview = document.getElementById('imgPreview');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                imgPreview.src = '';
                imgPreview.style.display = 'none';
            }
        });
    </script>
@endsection
