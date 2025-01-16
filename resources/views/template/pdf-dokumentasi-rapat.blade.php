<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ public_path('siwakjon2.png') }}" type="image/png" />
    <title>
        Dokumentasi {{ $rapat->detailRapat->perihal }}
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

        .img-dokumentasi {
            margin-top: 30px;
        }

        img {
            max-width: 80%;
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
        <h3 style="text-align: center; text-transform: uppercase;">DOKUMENTASI <br>
            {{ $rapat->detailRapat->perihal }} <br>
            {{ \App\Helpers\TimeSession::convertDateToIndonesian($rapat->detailRapat->tanggal_rapat) }}
        </h3>

        @foreach ($dokumentasi as $item)
            <div class="img-dokumentasi" align="center">
                <img src="{{ public_path('storage/' . $item->path_file_dokumentasi) }}" alt="Foto Rapat">
            </div>
        @endforeach

    </div>
    <div class="qrcode">
        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code {{ $qrCode }}">
        <span style="display: block; font-size:10px; margin-top: 5px;">{{ $url }}
            , Timestamp : {{ now() }}</span>
    </div>
</body>

</html>
