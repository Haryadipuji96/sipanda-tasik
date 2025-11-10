<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Tenaga Pendidik - IAIT</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 11px;
            color: #000;
            margin: 40px;
            line-height: 1.4;
        }

        /* === KOP SURAT === */
        .kop {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border-bottom: 2px solid #000;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }

        .kop::after {
            content: "";
            display: block;
            border-bottom: 1px solid #000;
            margin-top: 1px;
            width: 100%;
            position: absolute;
            bottom: -4px;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 75px;
            height: 75px;
        }

        .kop-text {
            text-align: center;
            flex: 1;
        }

        .kop-text h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text h2 {
            margin: 2px 0;
            font-size: 13px;
            font-weight: bold;
        }

        .kop-text p {
            margin: 1px 0;
            font-size: 10px;
        }

        /* === INFORMASI DOKUMEN === */
        .document-info {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .document-info strong {
            font-size: 11px;
            text-transform: uppercase;
        }

        /* === TABEL === */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px 6px;
            vertical-align: top;
        }

        th {
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        /* === FOOTER === */
        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 9px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .no-data {
            text-align: center;
            border: 1px solid #000;
            padding: 40px;
            font-style: italic;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop">
        <img class="logo" src="{{ public_path('images/Logo-IAIT.png') }}" alt="Logo IAIT">
        <div class="kop-text">
            <h1>INSTITUT AGAMA ISLAM TASIKMALAYA</h1>
            <h2>SEKOLAH TINGGI AGAMA ISLAM</h2>
            <p>Jl. Noenoeng Tisnasaputra No.16, Kahuripan, Tawang, Tasikmalaya</p>
            <p>Telepon: (0265) 331501 | Email: iaitasik@iaitasik.ac.id | Website: www.iaitasik.ac.id</p>
        </div>
    </div>

    <!-- INFORMASI DOKUMEN -->
    <div class="document-info">
        <strong>DATA TENAGA PENDIDIK / TENAGA KEPENDIDIKAN</strong><br>
        Dicetak pada: {{ date('d-m-Y H:i:s') }}
    </div>

    @if(isset($tenaga) && $tenaga->count() > 0)
    
    <p style="text-align:center; font-size:10px; margin-bottom:8px;">
        <strong>Total Data: {{ $tenaga->count() }} Tenaga Pendidik</strong>
    </p>

    <table>
        <thead>
            <tr>
                <th width="3%">NO</th>
                <th width="17%">NAMA LENGKAP</th>
                <th width="10%">NIP</th>
                <th width="8%">STATUS</th>
                <th width="4%">JK</th>
                <th width="13%">PROGRAM STUDI</th>
                <th width="13%">FAKULTAS</th>
                <th width="10%">TEMPAT LAHIR</th>
                <th width="8%">TGL LAHIR</th>
                <th width="8%">TMT KERJA</th>
                <th width="13%">PENDIDIKAN</th>
                <th width="12%">EMAIL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tenaga as $index => $tendik)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <strong>
                        {{ $tendik->gelar_depan ? $tendik->gelar_depan . ' ' : '' }}
                        {{ $tendik->nama_tendik }}
                        {{ $tendik->gelar_belakang ? ', ' . $tendik->gelar_belakang : '' }}
                    </strong>
                </td>
                <td>{{ $tendik->nip ?? '-' }}</td>
                <td class="text-center">{{ $tendik->status_kepegawaian }}</td>
                <td class="text-center">{{ $tendik->jenis_kelamin == 'laki-laki' ? 'L' : 'P' }}</td>
                <td>{{ $tendik->prodi->nama_prodi ?? 'Umum' }}</td>
                <td>{{ $tendik->prodi->fakultas->nama_fakultas ?? '-' }}</td>
                <td>{{ $tendik->tempat_lahir ?? '-' }}</td>
                <td class="text-center">{{ $tendik->tanggal_lahir ? \Carbon\Carbon::parse($tendik->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                <td class="text-center">{{ $tendik->tmt_kerja ? \Carbon\Carbon::parse($tendik->tmt_kerja)->format('d-m-Y') : '-' }}</td>
                <td>{{ $tendik->pendidikan_terakhir ?? '-' }}</td>
                <td>{{ $tendik->email ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <strong>DOKUMEN RESMI - INSTITUT AGAMA ISLAM TASIKMALAYA</strong><br>
        Sistem Informasi Akademik | Hal. 1
    </div>

    @else

    <div class="no-data">
        <h3>TIDAK ADA DATA TENAGA PENDIDIK</h3>
        <p>Tidak ditemukan data tenaga pendidik dalam sistem.</p>
    </div>

    <div class="footer">
        <strong>DOKUMEN RESMI - INSTITUT AGAMA ISLAM TASIKMALAYA</strong><br>
        Status: Tidak ada data yang ditemukan
    </div>

    @endif

</body>
</html>
