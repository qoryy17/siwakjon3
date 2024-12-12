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
                    <a href="{{ route('aplikasi.version') }}">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label class="form-label" for="releaseDate">Release Date
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="releaseDate" id="releaseDate"
                                placeholder="Select date" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="category">Category
                                <span class="text-danger">*</span>
                            </label>
                            <select name="category" id="category" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="Major">Major</option>
                                <option value="Minor">Minor</option>
                                <option value="Patch">Patch</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="patchVersion">Patch Version
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="patchVersion" id="patchVersion" required
                                placeholder="Patch Version...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pc_demo1">Note <span class="text-danger">*</span></label>
                            <textarea name="note" id="pc_demo1" class="form-control"></textarea>
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                Simpan</button>
                            <button type="reset" class="btn btn-sm btn-secondary"><i class="fas fa-recycle"></i>
                                Batal</button>
                            <a href="{{ route('aplikasi.version') }}" class="btn btn-sm btn-warning">
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
