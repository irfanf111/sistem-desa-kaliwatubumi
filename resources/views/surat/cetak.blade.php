<!DOCTYPE html>
<html>

<head>
    <title>Cetak Surat</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        /* Layout Kop Surat dengan Tabel agar Logo Rapi */
        .header-table {
            width: 100%;
            margin-bottom: 5px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo {
            width: 90px;
            height: auto;
        }

        .kop-teks {
            text-align: center;
            padding-right: 60px;
            /* Geser sedikit biar benar-benar tengah halaman */
        }

        .kop-teks h4,
        .kop-teks h3,
        .kop-teks h2 {
            margin: 0;
        }

        .kop-teks p {
            margin: 0;
            font-size: 10pt;
            font-style: italic;
        }

        .garis {
            border-bottom: 3px double black;
            margin-bottom: 20px;
        }

        .konten {
            margin-left: 30px;
            margin-right: 30px;
        }

        .ttd {
            float: right;
            margin-top: 50px;
            text-align: center;
        }

        table.data {
            width: 100%;
        }

        table.data td {
            vertical-align: top;
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td width="15%" align="center">
                <img src="{{ public_path('images/logo.png') }}" class="logo">
            </td>
            <td class="kop-teks">
                <h4>PEMERINTAH KABUPATEN PURWOREJO</h4>
                <h3>KECAMATAN BUTUH</h3>
                <h2>DESA KALIWATUBUMI</h2>
                <p>Alamat: Desa Kaliwatubumi, Kec. Butuh, Kab. Purworejo, Jawa Tengah 54264</p>
            </td>
        </tr>
    </table>

    <div class="garis"></div>

    <div class="konten">
        <center>
            <h3><u>{{ strtoupper($surat->jenis_surat->nama_surat) }}</u></h3>
            <p>Nomor: {{ $surat->no_surat }}</p>
        </center>

        <p>Yang bertanda tangan di bawah ini Kepala Desa Kaliwatubumi, Kecamatan Butuh, Kabupaten Purworejo, menerangkan
            bahwa:</p>

        <table class="data">
            <tr>
                <td width="150">Nama</td>
                <td>: <b>{{ $surat->penduduk->nama_lengkap }}</b></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $surat->penduduk->nik }}</td>
            </tr>
            <tr>
                <td>Tempat/Tgl Lahir</td>
                <td>: {{ $surat->penduduk->tempat_lahir }}, {{ $surat->penduduk->tanggal_lahir->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>: {{ $surat->penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>: {{ $surat->penduduk->pekerjaan }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $surat->penduduk->alamat }}</td>
            </tr>
        </table>

        <p>Orang tersebut di atas adalah benar-benar warga Desa Kaliwatubumi yang berdomisili di alamat tersebut.</p>

        <p>Surat keterangan ini dibuat untuk keperluan: <br>
            <b>"{{ $surat->keterangan }}"</b>
        </p>

        <p>Demikian surat keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>

        <div class="ttd">
            <p>Kaliwatubumi, {{ $surat->tanggal_surat->isoFormat('D MMMM Y') }}</p>
            <p>Kepala Desa,</p>
            <br><br><br>
            <p><b>( NAMA KADES )</b></p>
        </div>
    </div>

</body>

</html>