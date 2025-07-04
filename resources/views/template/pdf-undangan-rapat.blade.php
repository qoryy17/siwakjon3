<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('siwakjon2.png') }}" type="image/png" />
    <title>
        Undangan {{ $rapat->detailRapat->perihal }}
        {{ \App\Helpers\TimeSession::convertDateToIndonesian($rapat->detailRapat->tanggal_rapat) }}
    </title>

    <style type="text/css">
        .body {
            margin: 0 auto;
            font-family: sans-serif, 'Arial';
        }

        .header-kop {
            display: flex;
            justify-content: center;
        }

        .table-header-kop {
            width: 100%;
            text-align: center;
        }

        .img-logo {
            max-width: 80px;
        }

        .title {
            text-transform: uppercase;
            margin: 0;
        }

        .body-content {
            /* font-size: 15px; */
        }

        .table-content {
            width: 100%;
        }

        .table-agenda {
            width: 100%;
            margin-left: 40px;
        }

        .qrcode {
            position: fixed;
            right: 0%;
            top: 93%;
        }

        .url {
            position: fixed;
            right: 0%;
            top: 99%;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header-kop">
        <table class="table-header-kop">
            <tr>
                <td style="width: 1%">
                    <img class="img-logo" src="{{ asset('storage/' . $aplikasi->logo) }}" alt="">
                </td>
                <td>
                    <h4 class="title">
                        {{ $aplikasi->lembaga }} <br>
                        {{ $aplikasi->badan_peradilan }} <br>
                        {{ $aplikasi->wilayah_hukum }} <br>
                        {{ $aplikasi->satuan_kerja }}
                    </h4>
                    <p style="margin: 0;font-size:13px;">
                        {{ $aplikasi->alamat }} <br>
                        {{ $kabSurat }} {{ $aplikasi->kode_pos }}, {{ $aplikasi->website }},
                        {{ $aplikasi->email }}
                    </p>
                </td>
            </tr>
        </table>
    </div>
    <hr style="color: #000;">

    <div class="body-content">
        <p style="text-align: right;">
            {{ $kotaSurat }},
            {{ \App\Helpers\TimeSession::convertDateToIndonesian($rapat->detailRapat->created_at) }}
        </p>

        <table class="table-content" cellpadding="2">
            <tr>
                <td style="width: 10%;vertical-align:top;">Nomor</td>
                <td style="width: 1%;vertical-align:top;">:</td>
                <td style="vertical-align:top;">{{ $rapat->nomor_dokumen }}</td>
            </tr>
            <tr>
                <td style="width: 10%;vertical-align:top;">Sifat</td>
                <td style="width: 1%;vertical-align:top;">:</td>
                <td style="vertical-align:top;">{{ $rapat->detailRapat->sifat }}</td>
            </tr>
            <tr>
                <td style="width: 10%;vertical-align:top;">Lampiran</td>
                <td style="width: 1%;vertical-align:top;">:</td>
                <td style="vertical-align:top;">{{ $rapat->detailRapat->lampiran }}</td>
            </tr>
            <tr>
                <td style="width: 10%;vertical-align:top;">Hal</td>
                <td style="width: 1%;vertical-align:top;">:</td>
                <td style="vertical-align:top;line-height: 1.5;">{!! $rapat->detailRapat->perihal !!}</td>
            </tr>
            <tr>
                <td style="width: 10%;vertical-align:top;text-align:right;">Yth.</td>
                <td style="width: 1%;vertical-align:top;"></td>
                <td style="vertical-align:top;line-height: 1.5;text-align:justify;"><br> Kepada <br>
                    {!! $rapat->detailRapat->peserta !!}</td>
            </tr>
        </table>
        <p style="text-align: justify;line-height: 1.5;">
            Dengan Hormat, <br>
            Mengharapkan kehadiran Bapak/Ibu {!! $rapat->detailRapat->peserta !!} {{ $aplikasi->satuan_kerja }} untuk
            mengikuti kegiatan <strong>"{{ $rapat->detailRapat->acara }}"</strong> yang akan diselenggarakan pada :
        </p>
        <table class="table-agenda" cellpadding="2">
            <tr>
                <td style="width: 10%;vertical-align: top;">Hari</td>
                <td style="" style="width: 1%;vertical-align: top;">:</td>
                <td style="vertical-align: top;">
                    {{ \App\Helpers\TimeSession::convertDayIndonesian($rapat->detailRapat->tanggal_rapat) }}
                </td>
            </tr>
            <tr>
                <td style="width: 10%;vertical-align: top;">Tanggal</td>
                <td style="width: 1%;vertical-align: top;">:</td>
                <td style="vertical-align: top;">
                    {{ \App\Helpers\TimeSession::convertDateToIndonesian($rapat->detailRapat->tanggal_rapat) }}
                </td>
            </tr>
            <tr>
                <td style="width: 10%;vertical-align: top;">Pukul</td>
                <td style="width: 1%;vertical-align: top;">:</td>
                <td style="vertical-align: top;">
                    {{ $rapat->detailRapat->jam_mulai }} WIB
                </td>
            </tr>
            <tr>
                <td style="width: 5%;vertical-align: top;">Tempat</td>
                <td style="width: 1%;vertical-align: top;">:</td>
                <td style="vertical-align: top;line-height: 1.5;">
                    {!! $rapat->detailRapat->tempat !!}
                </td>
            </tr>
            <tr>
                <td style="width: 5%;vertical-align: top;">Acara</td>
                <td style="width: 1%;vertical-align: top;">:</td>
                <td style="vertical-align: top;line-height: 1.5;">
                    <span style="margin-right: 55px; text-align:justify;">
                        {!! $rapat->detailRapat->acara !!}
                    </span>
                </td>
            </tr>
            <tr>
                <td style="width: 5%;vertical-align: top;">Agenda</td>
                <td style="width: 1%;vertical-align: top;">:</td>
                <td style="vertical-align: top;line-height: 1.5;">
                    <span style="margin-right: 55px; text-align:justify;">
                        {!! $rapat->detailRapat->agenda !!}
                    </span>
                </td>
            </tr>
        </table>

        <p style="text-align: justify;line-height: 1.5;">
            {{ $rapat->detailRapat->keterangan }}
        </p style="text-align: justify;line-height: 1.5;">
        <p>
            Demikian pemberitahuan ini disampaikan, atas perhatian dan kerjasamanya kami ucapkan terimakasih.
        </p>

        <table style="width: 100%; margin-top: 50px;">
            <tr>
                <td style="width: 50%;">

                </td>
                <td>
                    <p style="text-align: center;">
                        @if ($pejabatPengganti != null)
                            <strong>{{ $pejabatPengganti }}</strong> <br>
                            {{ $aplikasi->satuan_kerja }} <br>
                            {{ $pegawai->jabatan->jabatan }}
                        @else
                            <strong>{{ $pegawai->jabatan->jabatan }}</strong> <br>
                            {{ $aplikasi->satuan_kerja }}
                        @endif


                        <span style="margin-top: 60px; display: block; font-weight: 700;">
                            {{ $pegawai->nama }} <br>
                        </span>
                    </p>
                </td>
            </tr>
        </table>
    </div>
    <div class="qrcode">
        <img src="{{ $qrCode }}" alt="QR Code {{ $qrCode }}">
    </div>
    <span class="url">{{ $url }}, Timestamp : {{ now() }}</span>
</body>

</html>
