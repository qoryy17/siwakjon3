<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('siwakjon2.png') }}" type="image/png" />
    <title>
        Daftar Hadir {{ $rapat->detailRapat->perihal }}
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
            /* font-size: 14px; */
        }

        .table-title {
            width: 100%;
            margin-bottom: 20px;
        }

        .table-present {
            width: 100%;
            border-collapse: collapse;
            /* font-size: 14px; */
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
                        {{ $kabSurat }} {{ $aplikasi->kode_pos }}, {{ $aplikasi->website }},
                        {{ $aplikasi->email }}
                    </p>
                </td>
            </tr>
        </table>
    </div>
    <hr style="color: #000;">

    <div class="body-content">
        <table class="table-title" cellpadding="4">
            <tr>
                <td colspan="3">
                    <h3 style="text-align: center;">DAFTAR KEHADIRAN</h3>
                </td>
            </tr>
            <tr>
                <td style="width: 7%;">Rapat</td>
                <td style="width: 1%;">:</td>
                <td>{{ $rapat->detailRapat->perihal }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ \App\Helpers\TimeSession::convertDateToIndonesian($rapat->detailRapat->tanggal_rapat) }}</td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td>:</td>
                <td>{{ $rapat->detailRapat->tempat }}</td>
            </tr>
        </table>
        <table class="table-present" border="1" cellpadding="10">
            <thead>
                <tr style="text-align: center; text-transform: uppercase;">
                    <th width="1%">No</th>
                    <th>Nama Lengkap</th>
                    <th>Jabatan/Bagian</th>
                    <th>Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < $peserta; $i++)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
    <div class="qrcode">
        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code {{ $qrCode }}">
    </div>
    <span class="url">{{ $url }}, Timestamp : {{ now() }}</span>
</body>

</html>
