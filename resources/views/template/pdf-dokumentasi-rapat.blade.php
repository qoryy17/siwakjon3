<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('siwakjon2.png') }}" type="image/png" />
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
        <h4 style="text-align: center; text-transform: uppercase;">DOKUMENTASI <br>
            {{ $rapat->detailRapat->perihal }} <br>
            {{ \App\Helpers\TimeSession::convertDateToIndonesian($rapat->detailRapat->tanggal_rapat) }}
        </h4>

        @foreach ($dokumentasi as $item)
            <div class="img-dokumentasi" align="center">
                <img src="{{ asset('storage/' . $item->path_file_dokumentasi) }}" alt="Foto Rapat">
            </div>
        @endforeach

    </div>
    <div class="qrcode">
        <img src="{{ $qrCode }}" alt="QR Code {{ $qrCode }}">
    </div>
    <span class="url">{{ $url }}, Timestamp : {{ now() }}</span>
</body>

</html>
