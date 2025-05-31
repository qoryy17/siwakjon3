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
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Daftar Hakim Pengawas</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->

            @if ($hakim->exists())
                <form action="{{ route('pengawasan.daftar-hakim-pengawas') }}" method="GET">
                    <div class="row align-items-center mb-3">
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-search"></i></span>
                                <input type="text" class="form-control" placeholder="Cari Dengan NIP Atau Nama..."
                                    name="search">
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary" type="button">Cari</button>
                        </div>
                    </div>
                </form>

                <div class="row">
                    @foreach ($hakim->get() as $item)
                        <div class="col-md-4 col-sm-12">
                            <div class="card">
                                <div class="card-body position-relative">
                                    <div class="text-center mt-3">
                                        <div class="chat-avtar d-inline-flex mx-auto">
                                            <img class="rounded-circle img-fluid wid-90 img-thumbnail"
                                                src="{{ $item->pegawai->foto ? asset('storage/' . $item->pegawai->foto) : asset('assets/images/user.png') }}"
                                                alt="User image">
                                            <i class="chat-badge bg-success me-2 mb-2"></i>
                                        </div>
                                        <h5 class="mb-0">{{ $item->pegawai->nama }}</h5>
                                        <p class="text-muted mt-1 text-sm m-0">Hakim Pengawas
                                            {{ $item->unitKerja->unit_kerja }}</p>
                                        <small class="text-secondary">Bergabung Sejak : {{ $item->created_at }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning" role="alert">
                    <p class="m-0">
                        Hakim Pengawas belum tersedia, Saat ini mungkin saja hakim pengawas belum ditambahkan oleh
                        Superadmin ataupun Administrator. Atau <br>
                        Pencarian belum ketemu nih, coba periksa kembali kata kunci pencarian kamu. <br><br>
                        Harap untuk mengecek kembali secara berkala <strong>Daftar Hakim Pengawas</strong>
                    </p>
                </div>
                <a href="{{ route('pengawasan.daftar-hakim-pengawas') }}" class="btn btn-primary">
                    <i class="fab fa-sistrix"></i> Cari Ulang
                </a>
            @endif

            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
