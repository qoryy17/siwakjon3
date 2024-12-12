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
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label class="form-label" for="nip">NIP</label>
                            <input type="text" class="form-control" placeholder="NIP..." id="nip" required>
                            <small class="text-danger">* Kosongkan jika tidak ada</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Lengkap
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" placeholder="Nama Lengkap..." id="nama"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jabatan">Jabatan
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" data-trigger name="jabatan" id="jabatan">
                                <option value="">Pilih Jabatan</option>
                                <option value="Choice 1">Choice 1</option>
                                <option value="Choice 2">Choice 2</option>
                                <option value="Choice 3">Choice 3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="active">Aktif
                                <span class="text-danger">*</span>
                            </label>
                            <select name="active" id="active" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="1">Aktif</option>
                                <option value="0">Non Aktif</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan..."></textarea>
                        </div>
                        <div class="form-file mb-3">
                            <label class="form-label" for="foto">Foto</label>
                            <input type="file" class="form-control" aria-label="foto" id="foto">
                            <small class="text-danger">* Unggah jika ada</small>
                        </div>
                        <div class="mb-3">
                            <img src="" alt="Pratinjau Gambar" class="img img-thumbnail" id="imgPreview"
                                style="display: none; max-width: 200px;">
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                Simpan</button>
                            <button type="reset" class="btn btn-sm btn-secondary"><i class="fas fa-recycle"></i>
                                Batal</button>
                            <a href="{{ route('pengguna.pegawai') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-reply"></i> Kembali
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
