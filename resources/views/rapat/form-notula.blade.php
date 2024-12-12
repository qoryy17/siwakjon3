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
                    <form action="" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label class="form-label" for="perihal">Perihal
                                <span class="text-danger">*</span>
                            </label>
                            <textarea readonly name="perihal" id="perihal" class="form-control" required placeholder="Perihal..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jamSelesai">Jam Selesai
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="jamSelesai" id="jamSelesai"
                                placeholder="Jam Selesai..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pembahasan">Pembahasan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="pembahasan" id="pembahasan" class="form-control" required placeholder="Pembahasan..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pimpinanRapat">Pimpinan Rapat
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="pimpinanRapat" id="pimpinanRapat" class="form-control" required placeholder="Pimpinan Rapat..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="moderator">Moderator</label>
                            <select class="form-control" data-trigger name="moderator" id="moderator">
                                <option value="">Pilih Moderator</option>
                                <option value="Choice 1">Choice 1</option>
                                <option value="Choice 2">Choice 2</option>
                                <option value="Choice 3">Choice 3</option>
                            </select>
                            <small class="text-danger">* Kosongkan jika tidak ada</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="notulen">Notulen</label>
                            <select class="form-control" data-trigger name="notulen" id="notulen" required>
                                <option value="">Pilih Notulen</option>
                                <option value="Choice 1">Choice 1</option>
                                <option value="Choice 2">Choice 2</option>
                                <option value="Choice 3">Choice 3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="catatan">Catatan <span class="text-danger">*</span></label>
                            <textarea name="catatan" id="catatan" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kesimpulan">Kesimpulan <span class="text-danger">*</span></label>
                            <textarea name="kesimpulan" id="kesimpulan" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="disahkan">Disahkan Oleh
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" data-trigger name="disahkan" id="disahkan">
                                <option value="">Pilih Pejabat/Pegawai</option>
                                <option value="Choice 1">Choice 1</option>
                                <option value="Choice 2">Choice 2</option>
                                <option value="Choice 3">Choice 3</option>
                            </select>
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                Simpan</button>
                            <button type="reset" class="btn btn-sm btn-secondary"><i class="fas fa-recycle"></i>
                                Batal</button>
                            <a href="{{ $routeBack }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-reply-all"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- Time picker -->
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <!-- [Page Specific JS] start -->
    <script src="{{ asset('assets/js/plugins/simplemde.min.js') }}"></script>
    <script>
        (function() {
            new SimpleMDE({
                element: document.querySelector("#catatan"),
            });

            new SimpleMDE({
                element: document.querySelector("#kesimpulan"),
            });

        })();
        document.querySelector('#jamSelesai').flatpickr({
            enableTime: true,
            noCalendar: true
        });
    </script>
@endsection
