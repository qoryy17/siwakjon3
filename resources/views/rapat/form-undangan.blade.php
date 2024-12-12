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
                    <div class="alert alert-warning mb-3" role="alert">
                        * Hanya diperbolehkan membuat untuk rapat
                        kedinasan. Rapat diluar kedinasan tidak boleh menggunakan {{ env('APP_NAME') }} !
                    </div>
                    <form action="" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="tanggalRapat">Tanggal Rapat
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="tanggalRapat" id="tanggalRapat"
                                        placeholder="Pilih Tanggal..." readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="jamRapat">Jam Rapat
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="jamRapat" id="jamRapat"
                                        placeholder="Jam Rapat..." required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sifat">Sifat
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="sifat" name="sifat" class="form-control" required
                                placeholder="Sifat...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="lampiran">Lampiran
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="lampiran" name="lampiran" class="form-control" required
                                placeholder="Lampiran...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="perihal">Perihal
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="perihal" id="perihal" class="form-control" required placeholder="Perihal..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="acara">Acara
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="acara" id="acara" class="form-control" required placeholder="Acara..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="agenda">Agenda
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="agenda" id="agenda" class="form-control" required placeholder="Agenda..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="peserta">Peserta
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="peserta" name="peserta" class="form-control" required
                                placeholder="Peserta...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tempat">Tempat
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="tempat" name="tempat" class="form-control" required
                                placeholder="Tempat...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pc_demo1">Keterangan <span
                                    class="text-danger">*</span></label>
                            <textarea name="keterangan" id="pc_demo1" class="form-control">Mengingat pentingnya rapat tersebut, dimohon agar Bapak/Ibu dapat menyiapkan agenda yang menjadi tanggung jawabnya dan dapat hadir tepat pada waktunya.</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pejabatPengganti">Pejabat Pengganti</label>
                            <select class="form-control" data-trigger name="pejabatPengganti" id="pejabatPengganti">
                                <option value="">Pilih Pejabat/Pegawai</option>
                                <option value="Choice 1">Choice 1</option>
                                <option value="Choice 2">Choice 2</option>
                                <option value="Choice 3">Choice 3</option>
                            </select>
                            <small class="text-danger">* Kosongkan jika tidak ada</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pejabatPenandatangan">Ditandatangin Oleh
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" data-trigger name="pejabatPenandatangan"
                                id="pejabatPenandatangan">
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
    <!-- Date picker -->
    <script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
    <!-- Time picker -->
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <script>
        (function() {
            const d_week2 = new Datepicker(document.querySelector("#tanggalRapat"), {
                buttonClass: "btn",
            });
        })();
        document.querySelector('#jamRapat').flatpickr({
            enableTime: true,
            noCalendar: true
        });
    </script>
@endsection
