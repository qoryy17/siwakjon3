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
            <div class="card mb-5">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h3 class="m-0">{{ $formTitle }}</h3>
                    <a href="{{ $routeBack }}">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengawasan.simpan-dokumentasi') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="mb-3" hidden>
                            <input type="text" class="form-control" readonly name="id"
                                value="{{ Crypt::encrypt($rapat->id) }}">
                        </div>
                        <div class="form-file mb-3">
                            <label class="form-label" for="file">Foto
                                <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" aria-label="file" id="file" name="file"
                                required>
                            @error('file')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <img src="" alt="Pratinjau Gambar" class="img img-thumbnail" id="imgPreview"
                                style="display: none; max-width: 500px;">
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-cloud-upload-alt"></i> Unggah
                            </button>
                            <a href="{{ $routeBack }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-reply-all"></i> Kembali
                            </a>
                        </div>
                    </form>

                    <div class="table-responsive mt-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>File</th>
                                    <th>Created At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($dokumentasi as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>
                                            <a target="_blank"
                                                href="{{ asset('storage/' . $item->path_file_dokumentasi) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        </td>
                                        <td>
                                            {{ $item->created_at }}
                                        </td>
                                        <td>
                                            <a href="#" class="avtar avtar-xs btn-link-danger"
                                                onclick=" Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Hapus Data ?',
                                                    text: 'Data yang dihapus tidak dapat dikembalikan !',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Hapus',
                                                    cancelButtonText: 'Batal',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById('deleteForm{{ $no }}').submit();
                                                    }
                                                });">
                                                <i class="ti ti-trash f-20"></i>
                                            </a>
                                            <form id="deleteForm{{ $no }}"
                                                action="{{ route('rapat.hapus-dokumentasi', ['id' => Crypt::encrypt($item->id)]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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
