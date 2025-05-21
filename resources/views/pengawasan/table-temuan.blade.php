<button data-pc-animate="fade-in-scale" data-bs-toggle="modal" data-bs-target="#animateModalTemuanAdd"
    class="btn btn-primary btn-sm">
    <i class="fas fa-file-pdf"></i> Tambah Temuan
</button>
<div class="table-responsive mt-3">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Temuan</th>
                <th>Waktu Penyelesaian</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if ($temuan->exists())
                @php
                    $no = 1;
                @endphp
                @foreach ($temuan->get() as $itemTemuan)
                    <tr>
                        <td style="vertical-align: top;">{{ $no }}</td>
                        <td style="vertical-align: top;">
                            <p style="text-align: justify;">
                                <strong>Judul</strong> : {!! $itemTemuan->judul !!}
                            </p>
                            <p style="text-align: justify;">
                                <strong>Kriteria</strong> : {!! $itemTemuan->kriteria !!}
                            </p>
                            <p style="text-align: justify;">
                                <strong>Kondisi</strong> {!! $itemTemuan->kondisi !!}
                            </p>
                            <p style="text-align: justify;">
                                <strong>Sebab</strong> : {!! $itemTemuan->sebab !!}
                            </p>
                            <p style="text-align: justify;">
                                <strong>Akibat</strong> : {!! $itemTemuan->akibat !!}
                            </p>
                            <p style="text-align: justify;">
                                <strong>Rekomendasi</strong> :
                                {!! $itemTemuan->rekomendasi !!}
                            </p>
                        </td>
                        <td style="vertical-align: top;">
                            {{ $itemTemuan->waktu_penyelesaian }}
                        </td>
                        <td style="vertical-align: top;">
                            {{ $itemTemuan->created_at }}
                        </td>
                        <td style="vertical-align: top;">
                            {{ $itemTemuan->updated_at }}
                        </td>
                        <td style="vertical-align: top;">
                            <a href="javascript:void(0);" class="avtar avtar-xs btn-link-secondary edit-temuan"
                                data-id="{{ Crypt::encrypt($itemTemuan->id) }}" data-judul="{{ $itemTemuan->judul }}"
                                data-kondisi="{{ $itemTemuan->kondisi }}" data-kriteria="{{ $itemTemuan->kriteria }}"
                                data-sebab="{{ $itemTemuan->sebab }}" data-akibat="{{ $itemTemuan->akibat }}"
                                data-rekomendasi="{{ $itemTemuan->rekomendasi }}"
                                data-waktuPenyelesaian="{{ $itemTemuan->waktu_penyelesaian }}">
                                <i class="ti ti-eye f-20"></i>
                            </a>
                            <a href="#" class="avtar avtar-xs btn-link-secondary"
                                onclick=" Swal.fire({
                                icon: 'warning',
                                title: 'Hapus Data ?',
                                text: 'Data yang dihapus tidak dapat dikembalikan !',
                                showCancelButton: true,
                                confirmButtonText: 'Hapus',
                                cancelButtonText: 'Batal',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('deleteForm{{ $no }}').submit();
                                }
                            });">
                                <i class="ti ti-trash f-20"></i>
                            </a>
                            <form id="deleteForm{{ $no }}"
                                action="{{ route('pengawasan.hapus-temuan', ['id' => Crypt::encrypt($itemTemuan->id)]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @php
                        $no++;
                    @endphp
                @endforeach
            @else
                <tr>
                    <td colspan="6">
                        Temuan pengawasan belum tersedia, silahkan tambah isi temuan
                        pengawasan ya.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
