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
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-file mb-3">
                            <label class="form-label" for="foto">Foto
                                <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" aria-label="foto" id="foto" required>
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
                                    <th>Filename</th>
                                    <th>Created At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Mark</td>
                                    <td>
                                        {{ now() }}
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-light-danger">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </td>
                                </tr>
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
