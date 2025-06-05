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
                                        <a href="{{ $bc['link'] }}" {{ $bc['page'] }}>{{ $bc['title'] }}</a>
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
                <div class="card-header">
                    <h3>Pengaturan Model Gemini AI</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning" role="alert">
                        <strong>Perhatian!</strong> Dokumentasi penggunaan model Gemini AI dapat dilihat pada tautan
                        berikut:
                        <a class="text-muted" target="_blank"
                            href="https://ai.google.dev/gemini-api/docs/rate-limits?authuser=1#free-tier">
                            https://ai.google.dev/gemini-api/docs/rate-limits?authuser=1#free-tier
                        </a>
                    </div>
                    <form action="{{ route('aplikasi.simpan-ai-model') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label class="form-label" for="aiModel">
                                AI Model <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="aiModel" id="aiModel" required
                                value="{{ $aiConfig->ai_model ?? old('aiModel') }}" placeholder="gemini-2.0-flash">
                            @error('aiModel')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="promptCatatanRapat">
                                Prompt Catatan Notula Rapat <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" name="promptCatatanRapat" id="promptCatatanRapat" required
                                placeholder="Perbaiki kalimat dibawah ini dengan sempurna sesuai bahasa yang baku serta kembangkan kalimat ini agar lebih informatif. Dan tanpa menggunakan opsi perbaikan">{{ $aiConfig->prompt_catatan_rapat ?? old('promptCatatanRapat') }}</textarea>
                            @error('promptCatatanRapat')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="promptKesimpulanRapat">
                                Prompt Kesimpulan Notula Rapat <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" name="promptKesimpulanRapat" id="promptKesimpulanRapat" required
                                placeholder="Perbaiki kalimat dibawah ini dengan sempurna sesuai bahasa yang baku serta kembangkan kalimat ini agar lebih informatif. Dan tanpa menggunakan opsi perbaikan">{{ $aiConfig->prompt_kesimpulan_rapat ?? old('promptKesimpulanRapat') }}</textarea>
                            @error('promptKesimpulanRapat')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
