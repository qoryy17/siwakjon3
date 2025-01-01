<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ public_path('siwakjon2.png') }}" type="image/png" />
    <title>
        Lembar Kunjungan Pengawasan Bidang {{ $title }}
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

        .table-visit {
            width: 100%;
            border-collapse: collapse;
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
        <h4 style="text-align: center; text-transform: uppercase;">
            Lembar Kunjungan Pengawasan Bidang <br> {{ $title }}
        </h4>

        <table class="table-visit" border="1" cellpadding="5" style="margin-top: 20px;">
            <tr>
                <td>
                    <strong>Tanggal Kunjungan</strong>
                </td>
                <td>
                    <strong>Waktu Kunjungan</strong>
                </td>
            </tr>
            <tr>
                <td>
                    {{ \App\Helpers\TimeSession::convertDayIndonesian($detailKunjungan->tanggal) }},
                    {{ \App\Helpers\TimeSession::convertDateToIndonesian($detailKunjungan->tanggal) }}
                </td>
                <td>{{ $detailKunjungan->waktu }} WIB</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Agenda</strong></td>
            </tr>
            <tr>
                <td colspan="2">
                    {{ $detailKunjungan->agenda }}
                </td>
            </tr>
            <tr>
                <td colspan="2"><strong>Pembahasan</strong></td>
            </tr>
            <tr>
                <td colspan="2">
                    {!! $detailKunjungan->pembahasan !!}
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Enim omnis libero necessitatibus ad
                    veritatis similique harum maiores perferendis temporibus qui labore deserunt debitis, quisquam
                    placeat laboriosam rerum fugit quos id.
                </td>
            </tr>
        </table>

        <table class="table-visit" style="margin-top: 50px;">
            <tr>
                <td style="width: 50%; text-align: center;">
                </td>
                <td style="width: 50%; text-align: center;">
                    Lubuk Pakam, {{ \App\Helpers\TimeSession::convertDateToIndonesian(date('Y-m-d')) }}
                    <br>
                    <strong>Hakim Pengawas Bidang </strong> <br>{{ $title }}

                    <br>
                    <p style="margin-top: 50px;">
                        <strong>
                            {{ $hakim->nama }}
                        </strong>
                    </p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
