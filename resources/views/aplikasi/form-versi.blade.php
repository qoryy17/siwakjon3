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
                    <form action="{{ route('aplikasi.simpan-version') }}" method="POST">
                        @csrf
                        @method('POST')
                        @if (Crypt::decrypt($paramOutgoing) == 'update')
                            <div class="mb-3" hidden>
                                <input type="text" class="form-control" readonly name="id"
                                    value="{{ Crypt::encrypt($version->id) }}">
                            </div>
                        @endif
                        <div class="mb-3" hidden>
                            <input type="text" class="form-control" name="param" readonly value="{{ $paramOutgoing }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="releaseDate">Release Date
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="releaseDate" id="releaseDate"
                                placeholder="Select date" readonly required
                                value="{{ $version ? Carbon\Carbon::createFromFormat('Y-m-d', $version->release_date)->format('m/d/Y') : old('releaseDate') }}">
                            @error('releaseDate')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="category">Category
                                <span class="text-danger">*</span>
                            </label>
                            <select name="category" id="category" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="Major"
                                    @if (old('category') == 'Major') selected @elseif ($version && $version->category == 'Major') selected @endif>
                                    Major</option>
                                <option value="Minor"
                                    @if (old('category') == 'Minor') selected @elseif ($version && $version->category == 'Minor') selected @endif>
                                    Minor</option>
                                <option value="Patch"
                                    @if (old('category') == 'Patch') selected @elseif ($version && $version->category == 'Patch') selected @endif>
                                    Patch</option>
                                @error('category')
                                    <small class="text-danger mt-1">* {{ $message }}</small>
                                @enderror
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="patchVersion">Patch Version
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="patchVersion" id="patchVersion" required
                                placeholder="Patch Version..."
                                value="{{ $version ? $version->patch_version : old('patchVersion') }}">
                            @error('patchVersion')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pc_demo1">Note <span class="text-danger">*</span></label>
                            <textarea name="note" id="pc_demo1" class="form-control" placeholder="Note...">{{ $version ? $version->note : old('note') }}</textarea>
                            @error('note')
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
                            <a href="{{ route('aplikasi.version') }}" class="btn btn-sm btn-warning">
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
