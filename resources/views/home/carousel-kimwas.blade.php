<div class="card">
    <div class="card-header">
        <h5>Hakim Pengawas</h5>
    </div>
    <div class="card-body">
        @if ($carouselWasbid['kimWasbid']->exists())
            <div id="carouselWasbid" class="carousel slide" data-bs-ride="carousel">
                @php
                    $i = 0;
                @endphp
                {{-- <ol class="carousel-indicators">
                    @for ($i = 0; $i < $carouselWasbid['countKimWasbid']; $i++)
                        <li data-bs-target="#carouselWasbid" data-bs-slide-to="{{ $i }}"
                            class="{{ $i == 0 ? 'active' : '' }}">
                        </li>
                    @endfor
                </ol> --}}
                <div class="carousel-inner">
                    @foreach ($carouselWasbid['kimWasbid']->get() as $item)
                        <div class="carousel-item text-center {{ $i == 0 ? 'active' : '' }}">
                            <img class="img-fluid rounded-circle" width="130px" height="130px"
                                src="{{ $item->pegawai && $item->pegawai->foto ? asset('storage/' . $item->pegawai->foto) : asset('assets/images/user.png') }}">
                            <h5 class="text-primary mt-3">{{ $item->pegawai->nama }}</h5>
                            <p>Hakim Pengawas {{ $item->unitKerja->unit_kerja }} <br>
                                Bergabung Sejak :
                                {{ \App\Helpers\TimeSession::convertDateToIndonesian($item->created_at) }}
                            </p>
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselWasbid" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselWasbid" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        @else
            <div class="alert alert-warning m-0 d-flex align-items-center gap-2" role="alert">
                <i class="ti ti-alert-circle f-30"></i> Hakim Pengawas belum tersedia !
            </div>
        @endif
    </div>
</div>
