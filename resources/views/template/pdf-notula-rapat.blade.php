<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ public_path('siwakjon2.png') }}" type="image/png" />
    <title>
        Notula {{ $rapat->detailRapat->perihal }}
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

        .table-title {
            width: 100%;
            margin-bottom: 20px;
        }

        .table-header-notula {
            width: 100%;
            border-collapse: collapse;
            /* font-size: 15px; */
            line-height: 1.5;
        }

        .pembahasan,
        .catatan,
        .kesimpulan {
            margin-top: 20px;
        }

        .pembahasan p,
        .catatan p,
        .kesimpulan p {
            /* font-size: 15px; */
        }

        .table-footer {
            width: 100%;
            /* font-size: 15px; */
        }

        .qrcode {
            position: fixed;
            left: 0%;
            top: 95%;
        }
    </style>
</head>

<body>
    <div class="header-kop">
        <table class="table-header-kop">
            <tr>
                <td style="width: 1%">
                    <img class="img-logo" src="{{ public_path('storage/' . $aplikasi->logo) }}" alt="">
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
                        {{ $aplikasi->kota }} {{ $aplikasi->kode_pos }}, {{ $aplikasi->website }},
                        {{ $aplikasi->email }}
                    </p>
                </td>
            </tr>
        </table>
    </div>
    <hr style="color: #000;">

    <div class="body-content">
        <table class="table-header-notula" cellpadding="2">
            <tr>
                <td colspan="3">
                    <h3 style="text-align: center;">NOTULA</h3>
                </td>
            </tr>
            <tr>
                <td style="width: 20%; vertical-align: top;">Dasar</td>
                <td style="width: 1%; vertical-align: top;">:</td>
                <td style="vertical-align: top; text-align: justify;">
                    Surat Undangan Nomor : {{ $rapat->nomor_dokumen }} tentang {{ $rapat->detailRapat->perihal }}
                    tanggal {{ \App\Helpers\TimeSession::convertDateToIndonesian($rapat->detailRapat->tanggal_rapat) }}
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td style="width: 20%; vertical-align: top;">Hari</td>
                <td style="width: 1%; vertical-align: top;">:</td>
                <td style="vertical-align: top;">
                    {{ \App\Helpers\TimeSession::convertDayIndonesian($rapat->detailRapat->tanggal_rapat) }}
                </td>
            </tr>
            <tr>
                <td style="width: 20%; vertical-align: top;">Tanggal</td>
                <td style="width: 1%; vertical-align: top;">:</td>
                <td style="vertical-align: top;">
                    {{ \App\Helpers\TimeSession::convertDateToIndonesian($rapat->detailRapat->tanggal_rapat) }}
                </td>
            </tr>
            <tr>
                <td style="width: 20%; vertical-align: top;">Pukul</td>
                <td style="width: 1%; vertical-align: top;">:</td>
                <td style="vertical-align: top;">
                    {{ $rapat->detailRapat->jam_mulai }} - {{ $rapat->DetailRapat->jam_selesai }}
                </td>
            </tr>
            <tr>
                <td style="width: 20%; vertical-align: top;">Tempat</td>
                <td style="width: 1%; vertical-align: top;">:</td>
                <td style="vertical-align: top;">
                    {{ $rapat->detailRapat->tempat }}
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td style="width: 20%; vertical-align: top;">Acara</td>
                <td style="width: 1%; vertical-align: top;">:</td>
                <td style="vertical-align: top; text-align: justify;">
                    {!! $rapat->detailRapat->acara !!}
                </td>
            </tr>
            <tr>
                <td style="width: 20%; vertical-align: top;">Agenda</td>
                <td style="width: 1%; vertical-align: top;">:</td>
                <td style="vertical-align: top; text-align: justify;">
                    {!! $rapat->detailRapat->agenda !!}
                </td>
            </tr>
            <tr>
                <td style="width: 20%; vertical-align: top;">Peserta</td>
                <td style="width: 1%; vertical-align: top;">:</td>
                <td style="vertical-align: top; text-align: justify;">
                    {{ $rapat->detailRapat->peserta }}
                </td>
            </tr>
        </table>
    </div>
    <div class="pembahasan">
        <h4>Pembahasan Rapat</h4>
        <p>
            {!! $rapat->detailRapat->pembahasan !!}
        </p>
    </div>

    <div class="catatan">
        <h4>Catatan Rapat</h4>
        <p>
            {!! $rapat->detailRapat->catatan !!}
        </p>
    </div>

    <div class="kesimpulan">
        <h4>Kesimpulan Rapat</h4>
        <p>
            {!! $rapat->detailRapat->kesimpulan !!}
        </p>
    </div>

    <table class="table-footer">
        <tr>
            <td class="width: 50%;">
                <p style="text-align: center;">
                    Notulis

                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <span style="font-weight: 800;">
                        {{ $notulis->nama }}
                    </span>
                </p>
            </td>
            <td class="width: 50%;">
                <p style="text-align: center;">
                    Mengetahui, <br>
                    Pimpinan Rapat

                    <br>
                    <br>
                    <br>
                    <br>
                    <span style="font-weight: 800;">
                        {{ $disahkan->nama }}
                    </span>
                </p>
            </td>
        </tr>
    </table>
    <div class="qrcode">
        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code {{ $qrCode }}">
        <span style="display: block; font-size:10px; margin-top: 5px;">{{ $url }}
            , Timestamp : {{ now() }}</span>
    </div>
</body>

</html>
