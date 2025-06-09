<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('siwakjon2.png') }}" type="image/png" />
    <title>
        Laporan Pengawasan {{ $title->objek_pengawasan }}
        {{ \App\Helpers\TimeSession::convertDateToIndonesian($rapat->detailRapat->tanggal_rapat) }}
    </title>

    <style type="text/css">
        .body {
            margin: 0 auto;
            font-family: sans-serif, 'Arial';
        }

        .page-break {
            page-break-before: always;
        }

        /* Cover CSS Style */
        .cover-title {
            text-transform: uppercase;
            text-align: center;
            margin-top: 70px;
            line-height: 1.5;
        }

        .cover-sk {
            text-align: center;
        }

        .cover-logo {
            margin-top: 100px;
            text-align: center;
            justify-content: center;
        }

        .logo {
            max-width: 300px;
        }

        .cover-pengawas {
            margin-top: 50px;
            text-align: center;
        }

        .cover-periode {
            margin-top: 150px;
            text-align: center;
            text-transform: uppercase;
        }

        /* Pengantar */
        .container-pengantar-ttd {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            grid-gap: 20px;
        }

        .pengantar-ttd {
            min-width: 200px;
            border: 1px solid black;
        }

        .qrcode {
            position: fixed;
            left: 0%;
            top: 95%;
        }
    </style>
</head>

<body>
    @php
        $tahun = \Carbon\Carbon::parse($rapat->detailRapat->tanggal_rapat);
    @endphp
    <!-- Cover -->
    <div class="cover">
        <h3 class="cover-title">
            LAPORAN PENGAWASAN BIDANG <br>{{ $title->objek_pengawasan }} <br>
            {{ $aplikasi->satuan_kerja }}
        </h3>
        <h3 class="cover-sk">
            NOMOR SK : {{ $aplikasi->sk_wasbid }}
        </h3>
        <div class="cover-logo">
            <img class="img-logo" width="250px" src="{{ asset('storage/' . $aplikasi->logo) }}" alt="logo">
        </div>

        <!-- Identity Pengawas -->
        <div class="cover-pengawas">
            <h4>OLEH TIM PENGAWAS :</h4>
            @php
                $pengawas = json_decode($title->hakim_pengawas);
            @endphp
            @foreach ($pengawas as $hakim)
                <p style="margin: 5px 0 0 0;">{{ $hakim->nama }}</p>
            @endforeach
        </div>

        <!-- Indetity Periode -->
        <div class="cover-periode">
            <h4>
                {{ $aplikasi->satuan_kerja }} <br>
                PERIODE {{ $periode }} TAHUN {{ $tahun->year }}
            </h4>
        </div>

        <!-- Disable for sheet -->
        <div class="qrcode">
            <img src="{{ $qrCode }}" alt="QR Code {{ $qrCode }}">
            <span style="display: block; font-size:10px; margin-top: 5px;">
                Copyright {{ env('APP_NAME') }}, Timestamp At : {{ now() }}
            </span>
        </div>
    </div>


    <!-- Break page -->
    <div class="page-break"></div>

    <!-- Pengantar -->
    <div class="pengantar">
        <p style="text-align: right;">
            {{ $kotaSurat }}, {{ \App\Helpers\TimeSession::convertDateToIndonesian(date('Y-m-d')) }}
        </p>
        <p style="text-align: left; line-height: 1.5;">
            Kepata Yth : <br>
            Ketua {{ $aplikasi->satuan_kerja }} <br>
            Cq. <br>
            Wakil Ketua {{ $aplikasi->satuan_kerja }} <br>
            Di - <br>
            <span style="margin-left: 20px">Lubuk Pakam</span>
        </p>

        <p style="text-align: justify; line-height: 1.5;">
            Dengan Hormat,
            Bersama dengan surat ini Kami beritahukan kepada Wakil Ketua selaku Koordinator Pengawasan, bahwa Kami
            selaku Hakim Pengawas Bidang
            {{ $title->objek_pengawasan }} pada {{ $aplikasi->satuan_kerja }} telah melakukan pengawasan pada tanggal,
            {{ \App\Helpers\TimeSession::convertDateToIndonesian($rapat->detailRapat->tanggal_rapat) }} untuk
            periode bulan {{ $periode }} tahun {{ $tahun->year }}, dan bersama ini kami serahkan Laporan Hasil
            Pengawasan
            tersebut kepada Wakil Ketua.
            <br>
            <br>
            Demikian laporan ini kami sampaikan, agar untuk menjadi bahan monitoring dan evaluasi.
        </p>

        <p style="margin-top: 20px;">
            Hormat Kami, <br>
            <strong>Hakim Pengawas Bidang {{ $title->objek_pengawasan }}</strong>
        </p>
        @php
            $no = 1;
            $pengawas = json_decode($title->hakim_pengawas);
        @endphp
        @foreach ($pengawas as $hakim)
            <p style="margin: 50px 0 0 0;">{{ $hakim->nama }}</p>
        @endforeach
    </div>

    <!-- Break page -->
    <div class="page-break"></div>

    <!-- Bab I Pendahuluan -->
    <div class="pendahuluan">
        <h3 style="text-align: center; text-transform: uppercase; line-height: 1.5;">
            BAB I <br>
            PENDAHULUAN
        </h3>
        <!-- Dasar Pelaksanaan -->
        <h4 style="margin: 50px 0 0 0;">1.1 Dasar Pelaksanaan Pengawasan</h4>
        <p style="margin: 0; padding: 0; text-align: justify; line-height: 1.5;">
            {!! $title->dasar_hukum !!}
        </p>

        <!-- Ruang Lingkup Pengawasan -->
        <h4 style="margin: 20px 0 0 0;">1.2 Ruang Lingkup Pengawasan</h4>
        {!! $title->deskripsi_pengawasan !!}

        <!-- Tujuan Pengawasan -->
        <h4 style="margin: 20px 0 0 0;">1.3 Tujuan Pengawasan</h4>
        <p style="margin: 0; padding: 0; text-align: justify; line-height: 1.5;">
            Berikut ini tujuan dalam pengawasan antara lain adalah :
        <ol style="margin: 0;padding: 0 0 0 25px; text-align: justify;">
            <li>Menjaga terselenggaranya manajemen peradilan dengan baik dan benar</li>
            <li>Menjaga terwujudnya tertib administrasi peradilan</li>
            <li>Menjaga pencapaian target yang telah ditetapkan sesuai dengan program kerja</li>
            <li>Menjaga citra lembaga peradilan yang bermartabat dan terhormat</li>
            <li>Menjaga citra aparat peradilan yang professional, bersih, dan berwibawa</li>
            <li>Meningkatkan kinerja pelayanan publik</li>
            <li>Meningkatkan disiplin dan prestasi kerja guna pencapaian pelaksanaan tugas yang optimal</li>
            <li>Mencegah terjadinya penyimpangan dan penyalahgunaan wewenang. Pengawasan rutin/ reguler
                dilaksanakan dengan tujuan terciptanya pelaksanaan tugas berdasarkan kode etik.</li>
            <li>Menopang kerangka manajemen peradilan yang baik</li>
            <li>Menciptakan kondisi yang mendukung kelancaran, kecepatan, dan ketepatan pelaksanaan tugas sesuai
                dengan tugas pokok dan fungsi peradilan</li>
            <li>Memberikan masukan berupa : data, fakta, pertimbangan, dan rekomendasi kepada atasan sebagai
                bahan untuk pengambilan keputusan</li>
            <li>Untuk memberikan pelayanan berkeadilan bagi masyarakat pada umumnya dan pengguna layanan
                pengadilan pada khususnya di {{ $aplikasi->satuan_kerja }}</li>
            <li>Sebagai Perpanjangan tangan Ketua Pengadilan Negeri Lubuk Pakam dalam mengawasi dan mengevaluasi
                fungsifungsi kinerja khususnya pada bagian Sub. Bagian Umum Dan Keuangan yang dilakukan secara
                optimal dan maksimal</li>
            <li>Memberikan masukan berupa temuan-temuan fakta permasalahan yang ada dilapangan, memberikan
                pertimbangan dan rekomendasi kepada pimpinan sebagai bahan perbaikan dan tindaklanjut dalam
                pengambilan keputusan</li>
            <li>Mendampingi terhadap perbaikan dari temuan - temuan Hakim Tinggi Pengawas Daerah
                {{ $aplikasi->wilayah_hukum }} dan Pengawas Eksternal lainnya baik dari
                {{ $aplikasi->badan_peradilan }} ataupun {{ $aplikasi->lembaga }}</li>
        </ol>
        </p>

        <!-- Metodologi Pengawasan -->
        <h4 style="margin: 50px 0 0 0;">1.4 Metodologi Pengawasan</h4>
        <p style="margin: 0; padding: 0; text-align: justify; line-height: 1.5;">
            Adapun metodologi yang digunakan dalam pengawasan sebagai berikut :
        <ol style="margin: 0;padding: 0 0 0 25px; text-align: justify;">
            <li>Melakukan pemeriksaan lapangan dan konfirmasi</li>
            <li>Melakukan pemeriksaan dokumen</li>
            <li>Melakukan wawancara</li>
            <li>Melakukan observasi</li>
        </ol>
        </p>
    </div>

    <!-- Break page -->
    <div class="page-break"></div>

    <!-- Bab II Uraian Hasil Pemeriksaan -->
    <div class="uraian">
        <h3 style="text-align: center; text-transform: uppercase;">
            BAB II <br>
            URAIAN HASIL PEMERIKSAAN
        </h3>
        <!-- Dasar Pelaksanaan -->
        @php
            $no = 1;
        @endphp
        @foreach ($pengawasan as $item)
            <h4 style="margin: 50px 0 0 0;">2.{{ $no++ }} Temuan Pemeriksaan</h4>
            <strong>{!! $item->judul !!}</strong>
            <p style="margin: 10px 0 0 0; padding: 0; text-align: justify; line-height: 1.5;">
                <strong>Kondisi :</strong> {!! $item->kondisi !!}
            </p>
            <p style="margin: 10px 0 0 0; padding: 0; text-align: justify; line-height: 1.5;">
                <strong>Kriteria :</strong> {!! $item->kriteria !!}
            </p>
            <p style="margin: 10px 0 0 0; padding: 0; text-align: justify; line-height: 1.5;">
                <strong>Sebab :</strong> {!! $item->sebab !!}
            </p>
            <p style="margin: 10px 0 0 0; padding: 0; text-align: justify; line-height: 1.5;">
                <strong>Akibat :</strong> {!! $item->akibat !!}
            </p>
            <p style="margin: 10px 0 0 0; padding: 0; text-align: justify; line-height: 1.5;">
                <strong>Rekomendasi :</strong> {!! $item->rekomendasi !!}
            </p>
            <p style="margin: 10px 0 0 0; padding: 0; text-align: justify; line-height: 1.5;">
                <strong>Waktu Penyelesaian :</strong> {{ $item->waktu_penyelesaian }}
            </p>
            @php
                $no++;
            @endphp
        @endforeach

    </div>

    <!-- Break page -->
    <div class="page-break"></div>

    <div class="kesimpulan">
        <h3 style="text-align: center; text-transform: uppercase;">
            BAB III <br>
            KESIMPULAN DAN REKOMENDASI
        </h3>
        <h4 style="margin: 20px 0 0 0;">3.1 Kesimpulan</h4>
        <span style="margin: 0; padding: 0; text-align: justify; line-height: 1.5;">{!! $title->kesimpulan !!}</span>
        <h4 style="margin: 20px 0 0 0;">3.2 Rekomendasi</h4>
        <span style="margin: 0; padding: 0; text-align: justify; line-height: 1.5;">{!! $title->rekomendasi !!}</span>

        <p style="margin: 20px 0 0 0; line-height: 1.5; text-align: justify;">
            Demikianlah Laporan Hasil Pengawasan ini dibuat dan ditandatangani oleh Tim Pengawas Bidang
            {{ $title->objek_pengawasan }} pada {{ $aplikasi->satuan_kerja }} dengan sebenarnya dan sesuai pada saat
            proses pengawasan ini dilakukan.
        </p>
        <p style="margin-top: 25px;">
            {{ $kotaSurat }}, {{ \App\Helpers\TimeSession::convertDateToIndonesian(date('Y-m-d')) }} <br>
            Hormat Kami, <br>
            <strong>Hakim Pengawas Bidang {{ $title->objek_pengawasan }}</strong>
        </p>
        @php
            $no = 1;
            $pengawas = json_decode($title->hakim_pengawas);
        @endphp
        @foreach ($pengawas as $hakim)
            <p style="margin: 50px 0 0 0;">{{ $hakim->nama }}</p>
        @endforeach
    </div>
</body>

</html>
