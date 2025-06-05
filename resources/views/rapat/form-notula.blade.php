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
                    <a href="{{ $routeBack }}">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('rapat.simpan-notula') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3" hidden>
                            <input type="text" class="form-control" readonly name="id"
                                value="{{ Crypt::encrypt($rapat->id) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="perihal">Perihal
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="perihal" id="perihal"
                                placeholder="Perihal..." required readonly
                                value="{{ $rapat->detailRapat->perihal ? $rapat->detailRapat->perihal : old('perihal') }}">
                            @error('perihal')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jamSelesai">Jam Selesai
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="jamSelesai" id="jamSelesai"
                                placeholder="Jam Selesai..." required
                                value="{{ $rapat->detailRapat->jam_selesai ? $rapat->detailRapat->jam_selesai : old('jamSelesai') }}">
                            @error('jamSelesai')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pembahasan">Pembahasan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="pembahasan" id="pembahasan" class="form-control" required placeholder="Pembahasan...">{{ str_replace('<br />', '', $rapat->detailRapat->pembahasan ? $rapat->detailRapat->pembahasan : old('pembahasan')) }}</textarea>
                            @error('pembahasan')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pimpinanRapat">Pimpinan Rapat
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="pimpinanRapat" id="pimpinanRapat" class="form-control" required placeholder="Pimpinan Rapat...">{{ str_replace('<br />', '', $rapat->detailRapat->pimpinan_rapat ? $rapat->detailRapat->pimpinan_rapat : old('pimpinanRapat')) }}</textarea>
                            @error('pimpinanRapat')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="moderator">Moderator</label>
                            <input type="text" class="form-control" name="moderator" id="moderator"
                                placeholder="Moderator..."
                                value="{{ $rapat->detailRapat->moderator ? $rapat->detailRapat->moderator : old('moderator') }}">
                            <small class="text-danger">* Kosongkan jika tidak ada</small>
                            @error('moderator')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="notulen">Notulis</label>
                            <select class="form-control" data-trigger name="notulen" id="notulen" required>
                                <option value="">Pilih Notulis</option>
                                @foreach ($pegawai as $notulen)
                                    <option value="{{ $notulen->id }}"
                                        @if (old('notulan') == $notulen->id) selected @elseif ($rapat->detailRapat->notulen == $notulen->id) selected @endif>
                                        {{ $notulen->nama }}</option>
                                @endforeach
                            </select>
                            @error('notulen')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="catatan">Catatan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="catatan" id="catatan" class="form-control" placeholder="Catatan..." rows="5">{!! $rapat->detailRapat->catatan ? $rapat->detailRapat->catatan : old('catatan') !!}</textarea>
                            @error('catatan')
                                <small class="text-danger mt-1">* {{ $message }}</small></br>
                            @enderror
                            <p class="text-danger mt-2 mb-1">
                                * Harap pastikan anda menyalin terlebih dahulu catatan
                                sebelum memakai fitur dibawah ini, karena jika sudah digenerate oleh AI tidak dapat
                                dikembalikan ! <br>
                                * Harap mengoreksi kembali hasil generate AI sebelum disimpan, karena bisa saja terdapat
                                kekeliruan. <br>
                                * Keakuratan hasil respon AI tergantung atas apa yang kamu masukan sebagai kesimpulan rapat.
                            </p>
                            <div class="mt-2 d-flex justify-content-between">
                                <button type="button" id="reqResponCatatan" onclick="requestResponAICatatan('catatan')"
                                    class="btn btn-info btn-sm">
                                    <i class="ti ti-database"></i> Sempurnakan Catatan Dengan AI
                                </button>
                                <small class="text-danger mt-1">
                                    * Tekan tombol Shift + Enter untuk baris baru pada editor
                                </small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kesimpulan">Kesimpulan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="kesimpulan" id="kesimpulan" class="form-control" placeholder="Kesimpulan...">{!! $rapat->detailRapat->kesimpulan ? $rapat->detailRapat->kesimpulan : old('kesimpulan') !!}</textarea>
                            @error('kesimpulan')
                                <small class="text-danger mt-1">* {{ $message }}</small></br>
                            @enderror
                            <p class="text-danger mt-2 mb-1">
                                * Harap pastikan anda menyalin terlebih dahulu kesimpulan sebelum memakai fitur dibawah ini,
                                karena jika sudah digenerate oleh AI tidak dapat
                                dikembalikan ! <br>
                                * Harap mengoreksi kembali hasil generate AI sebelum disimpan, karena bisa saja terdapat
                                kekeliruan. <br>
                                * Keakuratan hasil respon AI tergantung atas apa yang kamu masukan sebagai kesimpulan rapat.
                            </p>
                            <div class="mt-2 d-flex justify-content-between">
                                <button type="button" id="reqResponKesimpulan"
                                    onclick="requestResponAIKesimpulan('kesimpulan')" class="btn btn-info btn-sm">
                                    <i class="ti ti-database"></i> Sempurnakan Kesimpulan Dengan AI
                                </button>
                                <small class="text-danger mt-1">
                                    * Tekan tombol Shift + Enter untuk baris baru pada editor
                                </small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="disahkan">Disahkan Oleh
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" data-trigger name="disahkan" id="disahkan">
                                <option value="">Pilih Pejabat/Pegawai</option>
                                @foreach ($pegawai as $disahkan)
                                    <option value="{{ $disahkan->id }}"
                                        @if (old('notulan') == $disahkan->id) selected @elseif ($rapat->detailRapat->disahkan == $disahkan->id) selected @endif>
                                        {{ $disahkan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
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
    <!-- Modal Notification -->
    <div id="modalAINotula" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalAINotulaTitle"
        aria-hidden="true">
        <x-modal.modal-notif-ai-notula />
    </div>
    <!-- End Modal Notification -->
    <!-- Time picker -->
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <!-- Ckeditor js -->
    <script src="{{ asset('assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
    @include('rapat.script-js-notula')
@endsection
