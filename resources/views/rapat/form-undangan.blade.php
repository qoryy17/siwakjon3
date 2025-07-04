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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h4 class="alert-heading">Peringatan!</h4>
                            <div class="alert-body">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('rapat.simpan-rapat') }}" method="POST">
                        @csrf
                        @method('POST')
                        @if (Crypt::decrypt($paramOutgoing) == 'update')
                            <div class="mb-3" hidden>
                                <input type="text" class="form-control" readonly name="id"
                                    value="{{ Crypt::encrypt($rapat->id) }}">
                            </div>
                        @endif
                        <div class="mb-3" hidden>
                            <input type="text" class="form-control" name="param" readonly value="{{ $paramOutgoing }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12" hidden>
                                <div class="mb-3">
                                    <label class="form-label" for="klasifikasiRapat">Klasifikasi Rapat
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="klasifikasiRapat" id="klasifikasiRapat"
                                        placeholder="Klasifikasi Rapat..." required required readonly
                                        value="{{ $klasifikasi['rapat'] }}">
                                    @error('klasifikasiRapat')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            @if (Crypt::decrypt($paramOutgoing) == 'save')
                                <div class="col-md-6 col-sm-12" hidden>
                                    <div class="mb-3">
                                        <label class="form-label" for="klasifikasiJabatan">Klasifikasi Jabatan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="klasifikasiJabatan"
                                            id="klasifikasiJabatan" placeholder="Klasifikasi Jabatan..." required required
                                            readonly value="{{ $klasifikasi['jabatan'] }}">
                                        @error('klasifikasiJabatan')
                                            <small class="text-danger mt-1">* {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="nomorDokumen">Nomor Dokumen Rapat
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="nomorDokumen" id="nomorDokumen"
                                        placeholder="Nomor Dokumen Rapat..." required value="{{ $nomorDokumen }}" readonly>
                                    @error('nomorDokumen')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="tanggalRapat">Tanggal Rapat
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="tanggalRapat" id="tanggalRapat"
                                        placeholder="Pilih Tanggal..." readonly required
                                        value="{{ $rapat ? Carbon\Carbon::createFromFormat('Y-m-d', $rapat->detailRapat->tanggal_rapat)->format('m/d/Y') : old('tanggalRapat') }}">
                                    @error('tanggalRapat')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="jamRapat">Jam Rapat
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="jamRapat" id="jamRapat"
                                        placeholder="Jam Rapat..." required
                                        value="{{ $rapat ? $rapat->detailRapat->jam_mulai : old('jamRapat') }}">
                                    @error('jamRapat')
                                        <small class="text-danger mt-1">* {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sifat">Sifat
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="sifat" name="sifat" class="form-control" required
                                placeholder="Penting/Biasa/Terbatas/Rahasia..."
                                value="{{ $rapat ? $rapat->detailRapat->sifat : old('sifat') }}">
                            @error('sifat')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="lampiran">Lampiran
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="lampiran" name="lampiran" class="form-control" required
                                placeholder="Lampiran..."
                                value="{{ $rapat ? $rapat->detailRapat->lampiran : old('lampiran') }}">
                            @error('lampiran')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="perihal">Perihal
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="perihal" id="perihal" class="form-control" required
                                placeholder="Monitoring dan Evaluasi Periode Triwulan III...">{{ $rapat ? $rapat->detailRapat->perihal : old('perihal') }}</textarea>
                            @error('perihal')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="acara">Acara
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="acara" id="acara" class="form-control" required
                                placeholder="Monitoring dan Evaluasi Periode Triwulan III Pada Kepaniteraan Perdata...">{{ $rapat ? $rapat->detailRapat->acara : old('acara') }}</textarea>
                            @error('acara')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="agenda">Agenda
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="agenda" id="agenda" class="form-control" required
                                placeholder="Pembinaan dan Pengawasan/Monitoring dan Evaluasi/Uji Petik Kesesuaian Administrasi...">{{ str_replace('<br />', '', $rapat ? $rapat->detailRapat->agenda : old('agenda')) }}</textarea>
                            @error('agenda')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="peserta">Peserta
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="peserta" name="peserta" class="form-control" required
                                placeholder="Panitera/Panitera Muda/Seluruh Staf Kepaniteraan Perdata..."
                                value="{{ $rapat ? $rapat->detailRapat->peserta : old('peserta') }}">
                            @error('peserta')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tempat">Tempat
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="tempat" name="tempat" class="form-control" required
                                placeholder="Ruang Media Center..."
                                value="{{ $rapat ? $rapat->detailRapat->tempat : old('tempat') }}">
                            @error('tempat')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pc_demo1">Keterangan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="keterangan" id="pc_demo1" class="form-control">{{ str_replace('<br />', '', $rapat ? $rapat->detailRapat->keterangan : 'Mengingat pentingnya rapat tersebut, dimohon agar Bapak/Ibu dapat menyiapkan agenda yang menjadi tanggung jawabnya dan dapat hadir tepat pada waktunya.') }}</textarea>
                            @error('keterangan')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pejabatPengganti">Pejabat Pengganti</label>
                            <select class="form-control" data-trigger name="pejabatPengganti" id="pejabatPengganti">
                                <option value="">Pilih Pejabat/Pegawai</option>
                                {{-- <option value="">Tanpa Pejabat/Pegawai</option> --}}
                                @foreach ($pejabatPengganti as $itemPejabat)
                                    <option value="{{ $itemPejabat->id }}"
                                        @if (old('pejabatPengganti') == $itemPejabat->id) selected @elseif($rapat && $rapat->pejabat_pengganti_id == $itemPejabat->id) selected @endif>
                                        {{ $itemPejabat->pejabat }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-danger">
                                * Kosongkan jika tidak ada </br> * Apabila penandatangan rapat bukan
                                pejabat/jabatan struktural (Cth: Hakim Pengawas/Koordinator, dll) maka pilih pejabat
                                pengganti
                            </small>
                            @error('pejabatPengganti')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pejabatPenandatangan">Ditandatangani Oleh
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" data-trigger name="pejabatPenandatangan"
                                id="pejabatPenandatangan" required>
                                <option value="">Pilih Pejabat/Pegawai</option>
                                @foreach ($pegawai as $itemPegawai)
                                    <option value="{{ $itemPegawai->id }}"
                                        @if (old('pejabatPenandatangan') == $itemPegawai->id) selected @elseif($rapat && $rapat->pejabat_penandatangan == $itemPegawai->id) selected @endif>
                                        {{ $itemPegawai->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pejabatPenandatangan')
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
                            <a href="{{ $routeBack }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-reply-all"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
                <!-- [ Main Content ] end -->
            </div>
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
