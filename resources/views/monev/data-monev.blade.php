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
                <div class="card-header">
                    <h3>Laporan Monev</h3>
                    <small class="d-block mb-2">
                        Pengumpulan Arsip Laporan Monitoring dan Evaluasi Berserta Tindaklanjut
                    </small>
                    @if (Auth::user()->roles == App\Enum\RolesEnum::SUPERADMIN->value ||
                            Auth::user()->roles == App\Enum\RolesEnum::ADMIN->value ||
                            App\Helpers\ViewUser::jabatan() == App\Enum\JabatanEnum::HAKIM->value)
                        <a href="{{ route('monev.formAgendaMonev', ['param' => Crypt::encrypt('add'), 'id' => 'null']) }}"
                            class="btn btn-primary btn-sm"><i class="ph-duotone ph-file-plus"></i>
                            Tambah
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Agenda</th>
                                    <th>Unit Kerja</th>
                                    <th>Aktif</th>
                                    <th>Dibuat</th>
                                    <th>Tahun</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($monev as $item)
                                    @php
                                        $dibuat = \App\Models\User::find($item->dibuat);
                                    @endphp
                                    <tr>
                                        <td style="vertical-align: top;" class="text-start">{{ $no }}</td>
                                        <td style="vertical-align: top;">
                                            {{ $item->nama_agenda }} <br>
                                            Nomor : {{ $item->nomor_agenda }}
                                        </td>
                                        <td style="vertical-align: top;">{{ $item->unit_kerja }}</td>
                                        <td style="vertical-align: top;">{{ $item->aktif }}</td>
                                        <td style="vertical-align: top;">{{ $dibuat->name }}</td>
                                        <td style="vertical-align: top;" class="text-start">
                                            {{ Carbon\Carbon::parse($item->created_at)->format('Y') }}
                                        </td>
                                        <td style="vertical-align: top;">{{ $item->created_at }}</td>
                                        <td style="vertical-align: top;">{{ $item->updated_at }}</td>
                                        <td style="vertical-align: top;">
                                            <a href="{{ route('monev.detailAgendaMonev', ['id' => Crypt::encrypt($item->id)]) }}"
                                                class="avtar avtar-xs btn-link-secondary">
                                                <i class="ti ti-eye f-20"></i>
                                            </a>
                                            @if (Auth::user()->roles != App\Enum\RolesEnum::USER->value)
                                                <a href="{{ route('monev.formAgendaMonev', ['param' => Crypt::encrypt('edit'), 'id' => Crypt::encrypt($item->id)]) }}"
                                                    class="avtar avtar-xs btn-link-secondary">
                                                    <i class="ti ti-edit f-20"></i>
                                                </a>
                                                <a href="#" class="avtar avtar-xs btn-link-secondary"
                                                    onclick=" Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Hapus Data ?',
                                                    text: 'Data yang dihapus tidak dapat dikembalikan ! \n Seluruh data agenda monev akan dihapus !',
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
                                                    action="{{ route('monev.hapus-agenda', ['id' => Crypt::encrypt($item->id)]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif

                                        </td>
                                    </tr>
                                    @php
                                        $no++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
