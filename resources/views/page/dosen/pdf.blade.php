<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lengkap Dosen - {{ $dosen->nama }}</title>
    <style>
        @page {
            margin: 2cm 1.5cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            background-color: #fff;
        }

        /* === KOP SURAT === */
        .kop {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .kop img {
            width: 75px;
            position: absolute;
            left: 20px;
            top: 10px;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
        }

        .kop-text h3 {
            margin: 2px 0;
            font-size: 11pt;
            font-weight: normal;
        }

        /* === JUDUL === */
        .judul {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 25px 0 20px;
            text-transform: uppercase;
        }

        /* === SECTION TITLE === */
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            background-color: #efefef;
            padding: 6px 10px;
            margin-top: 25px;
            margin-bottom: 10px;
            border-left: 4px solid #333;
        }

        /* === TABEL BIODATA === */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table.biodata td {
            padding: 6px 10px;
            border: 1px solid #000;
            vertical-align: top;
        }

        table.biodata td:first-child {
            width: 35%;
            font-weight: bold;
            background-color: #f9f9f9;
        }

        /* === TABEL PENDIDIKAN === */
        table.pendidikan {
            border: 1px solid #000;
            margin-top: 5px;
        }

        table.pendidikan th {
            background-color: #dcdcdc;
            font-weight: bold;
            padding: 8px;
            border: 1px solid #000;
            text-align: center;
        }

        table.pendidikan td {
            padding: 6px 8px;
            border: 1px solid #000;
            text-align: center;
        }

        /* === STATUS BADGE === */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10.5pt;
        }

        .status-sudah {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-belum {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* === FOOTER === */
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11pt;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .footer p {
            margin: 3px 0;
        }
    </style>
</head>

<body>

    <!-- KOP SURAT -->
    <div class="kop">
        <img src="{{ public_path('images/Logo-IAIT.png') }}" alt="Logo IAIT">
        <div class="kop-text">
            <h2>INSTITUT AGAMA ISLAM TASIKMALAYA</h2>
            <h3>Jl. Noenoeng Tisnasaputra No.16, Tasikmalaya</h3>
            <h3>Tlp. (0265) 331501 | Email: iaitasik@iaitasik.ac.id | Web: www.iaitasik.ac.id</h3>
        </div>
    </div>

    <!-- JUDUL -->
    <div class="judul">
        DATA LENGKAP DOSEN
    </div>

    <!-- DATA PRIBADI -->
    <div class="section-title">DATA PRIBADI</div>
    <table class="biodata">
        <tr>
            <td>Nama Lengkap</td>
            <td>{{ $dosen->nama }}</td>
        </tr>
        <tr>
            <td>Program Studi</td>
            <td>{{ $dosen->prodi->nama_prodi ?? '-' }} ({{ $dosen->prodi->fakultas->nama_fakultas ?? '-' }})</td>
        </tr>
        <tr>
            <td>Tempat / Tanggal Lahir</td>
            <td>{{ $dosen->tempat_tanggal_lahir }}</td>
        </tr>
        <tr>
            <td>NIDN</td>
            <td>{{ $dosen->nik ?? '-' }}</td>
        </tr>
    </table>

    <!-- RIWAYAT PENDIDIKAN -->
    <div class="section-title">RIWAYAT PENDIDIKAN</div>
    @if ($dosen->pendidikan_terakhir)
        <p><strong>Pendidikan Terakhir:</strong> {{ $dosen->pendidikan_terakhir }}</p>
    @endif

    <table class="pendidikan">
        <thead>
            <tr>
                <th width="15%">Jenjang</th>
                <th width="30%">Prodi / Jurusan</th>
                <th width="20%">Tahun Lulus</th>
                <th width="35%">Nama Universitas / PT</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dosen->pendidikan_array as $pend)
                <tr>
                    <td>{{ $pend['jenjang'] ?? '-' }}</td>
                    <td>{{ $pend['prodi'] ?? '-' }}</td>
                    <td>{{ $pend['tahun_lulus'] ?? '-' }}</td>
                    <td>{{ $pend['universitas'] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; font-style:italic; color:#666;">
                        Belum ada data riwayat pendidikan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- DATA KEPEGAWAIAN -->
    <div class="section-title">DATA KEPEGAWAIAN</div>
    <table class="biodata">
        <tr>
            <td>Jabatan</td>
            <td>{{ $dosen->jabatan ?? '-' }}</td>
        </tr>
        <tr>
            <td>TMT Kerja</td>
            <td>{{ $dosen->tmt_kerja ?? '-' }}</td>
        </tr>
        <tr>
            <td>Masa Kerja</td>
            <td>{{ $dosen->masa_kerja_tahun ?? 0 }} Tahun {{ $dosen->masa_kerja_bulan ?? 0 }} Bulan</td>
        </tr>
        <tr>
            <td>Pangkat / Golongan</td>
            <td>{{ $dosen->pangkat_golongan ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jabatan Fungsional</td>
            <td>{{ $dosen->jabatan_fungsional ?? '-' }}</td>
        </tr>
        <tr>
            <td>Masa Kerja Golongan</td>
            <td>{{ $dosen->masa_kerja_golongan_tahun ?? 0 }} Tahun {{ $dosen->masa_kerja_golongan_bulan ?? 0 }} Bulan</td>
        </tr>
        <tr>
            <td>No SK</td>
            <td>{{ $dosen->no_sk ?? '-' }}</td>
        </tr>
        <tr>
            <td>JaFung (No SK)</td>
            <td>{{ $dosen->no_sk_jafung ?? '-' }}</td>
        </tr>
    </table>

    <!-- STATUS -->
    <div class="section-title">STATUS</div>
    <table class="biodata">
        <tr>
            <td>Sertifikasi</td>
            <td>
                <span class="status-badge {{ $dosen->sertifikasi == 'SUDAH' ? 'status-sudah' : 'status-belum' }}">
                    {{ $dosen->sertifikasi }}
                </span>
            </td>
        </tr>
        <tr>
            <td>Inpasing</td>
            <td>
                <span class="status-badge {{ $dosen->inpasing == 'SUDAH' ? 'status-sudah' : 'status-belum' }}">
                    {{ $dosen->inpasing }}
                </span>
            </td>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
        <p style="font-style: italic; font-size: 10pt;">Dokumen ini dibuat secara otomatis oleh sistem</p>
    </div>

</body>

</html>
