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
                    <h3>Set Rapat</h3>
                    <small>Set Rapat Untuk Rapat Kedinasan dan Rapat Pengawasan</small>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning" role="alert">
                        <p class="m-0">
                            <strong>Perhatian !</strong>
                            Tidak dapat mengubah klasifikasi rapat pengawasan apabila sudah mengisi laporan hasil
                            pengawasan, jenis rapat yang dapat diubah adalah rapat bulanan, berjenjang, lainnya dan rapat
                            pengawasan yang belum di isi laporan hasil pengawasannya.
                        </p>
                    </div>

                    <form action="{{ route('rapat.simpan-set-rapat') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label class="form-label" for="rapat">Rapat Dinas / Pengawasan</label>
                            <select class="form-select" id="rapat" data-trigger name="rapat">
                                <option value="">Pilih Rapat</option>
                                @foreach ($rapat as $item)
                                    <option value="{{ Crypt::encrypt($item->id) }}">
                                        Nomor : {{ $item->nomor_dokumen }} |
                                        Perihal {{ $item->detailRapat->perihal }}
                                        Tanggal Rapat :
                                        {{ \App\Helpers\TimeSession::convertDateToIndonesian($item->tanggal_rapat) }},
                                        Klasifikasi Rapat : {{ $item->klasifikasiRapat->rapat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rapat')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nomorRapat">Nomor Dokumen Rapat</label>
                            <input type="number" class="form-control" id="nomorRapat" name="nomorRapat"
                                placeholder="Nomor Dokumen Rapat..." />
                            <small class="text-danger">
                                * Isi dengan angka jika ingin mengganti nomor dokumen rapat, kosongkan jika tidak ingin
                                mengganti.
                            </small>
                            @error('nomorRapat')
                                <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="klasifikasi">Set Klasifikasi Rapat</label>
                            <select class="form-select" id="klasifikasi" name="klasifikasi">
                                <option value="">Pilih Klasifikasi Rapat</option>
                                @foreach ($klasifikasi as $klasifikasiRapat)
                                    <option value="{{ Crypt::encrypt($klasifikasiRapat->id) }}">
                                        {{ $klasifikasiRapat->rapat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('klasifikasi')
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
