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

        /* === FILE INDICATOR === */
        .file-indicator {
            display: inline-block;
            margin-left: 10px;
            padding: 2px 8px;
            background-color: #e8f5e8;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: normal;
        }

        /* === GELAR STYLE === */
        .nama-lengkap {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .gelar-info {
            font-size: 10pt;
            color: #555;
            margin-bottom: 3px;
        }

        /* === BERKAS SECTION === */
        .berkas-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-top: 10px;
        }

        .berkas-item {
            padding: 6px 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 10pt;
        }

        .berkas-ada {
            background-color: #f0f9ff;
            border-color: #bae6fd;
        }

        .berkas-tidak {
            background-color: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .berkas-status {
            float: right;
            font-weight: bold;
            font-size: 9pt;
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
            <td>
                <div class="nama-lengkap">
                    {{ $dosen->gelar_depan ? $dosen->gelar_depan . ' ' : '' }}{{ $dosen->nama }}{{ $dosen->gelar_belakang ? ', ' . $dosen->gelar_belakang : '' }}
                </div>
                @if ($dosen->gelar_depan || $dosen->gelar_belakang)
                    <div class="gelar-info">
                        <strong>Gelar Depan:</strong> {{ $dosen->gelar_depan ?? '-' }} |
                        <strong>Gelar Belakang:</strong> {{ $dosen->gelar_belakang ?? '-' }}
                    </div>
                @endif
            </td>
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
        <tr>
            <td>NUPTK</td>
            <td>{{ $dosen->nuptk ?? '-' }}</td>
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
            <td>{{ $dosen->masa_kerja_golongan_tahun ?? 0 }} Tahun {{ $dosen->masa_kerja_golongan_bulan ?? 0 }} Bulan
            </td>
        </tr>
        <tr>
            <td>No SK</td>
            <td>{{ $dosen->no_sk ?? '-' }}</td>
        </tr>
        <tr>
            <td>JaFung (No SK)</td>
            <td>{{ $dosen->no_sk_jafung ?? '-' }}</td>
        </tr>
        <!-- STATUS DOSEN - TAMBAHKAN SETELAH JaFung -->
        <tr>
            <td>Status Dosen</td>
            <td>
                <span
                    style="padding: 4px 8px; border-radius: 3px; font-weight: bold; font-size: 10.5pt;
            {{ $dosen->status_dosen == 'DOSEN_TETAP' ? 'background-color: #d4f7dc; color: #0d5c1c; border: 1px solid #a3e9b3;' : '' }}
            {{ $dosen->status_dosen == 'DOSEN_TIDAK_TETAP' ? 'background-color: #fff3cd; color: #856404; border: 1px solid #ffeaa7;' : '' }}
            {{ $dosen->status_dosen == 'PNS' ? 'background-color: #cce7ff; color: #004085; border: 1px solid #99d1ff;' : '' }}">
                    {{ $dosen->status_dosen_text }}
                </span>
            </td>
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
                @if ($dosen->sertifikasi == 'SUDAH' && $dosen->file_sertifikasi)
                    <span class="file-indicator">File Tersedia</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>Inpasing</td>
            <td>
                <span class="status-badge {{ $dosen->inpasing == 'SUDAH' ? 'status-sudah' : 'status-belum' }}">
                    {{ $dosen->inpasing }}
                </span>
                @if ($dosen->inpasing == 'SUDAH' && $dosen->file_inpasing)
                    <span class="file-indicator">File Tersedia</span>
                @endif
            </td>
        </tr>
    </table>

    <!-- BERKAS UPLOAD -->
    <div class="section-title">BERKAS UPLOAD</div>
    <div class="berkas-grid">
        <!-- Baris 1 -->
        <div class="berkas-item {{ $dosen->file_ktp ? 'berkas-ada' : 'berkas-tidak' }}">
            KTP <span class="berkas-status">{{ $dosen->file_ktp ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>
        <div class="berkas-item {{ $dosen->file_ijazah_s1 ? 'berkas-ada' : 'berkas-tidak' }}">
            Ijazah S1 <span class="berkas-status">{{ $dosen->file_ijazah_s1 ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>

        <!-- Baris 2 -->
        <div class="berkas-item {{ $dosen->file_transkrip_s1 ? 'berkas-ada' : 'berkas-tidak' }}">
            Transkrip S1 <span class="berkas-status">{{ $dosen->file_transkrip_s1 ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>
        <div class="berkas-item {{ $dosen->file_ijazah_s2 ? 'berkas-ada' : 'berkas-tidak' }}">
            Ijazah S2 <span class="berkas-status">{{ $dosen->file_ijazah_s2 ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>

        <!-- Baris 3 -->
        <div class="berkas-item {{ $dosen->file_transkrip_s2 ? 'berkas-ada' : 'berkas-tidak' }}">
            Transkrip S2 <span class="berkas-status">{{ $dosen->file_transkrip_s2 ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>
        <div class="berkas-item {{ $dosen->file_ijazah_s3 ? 'berkas-ada' : 'berkas-tidak' }}">
            Ijazah S3 <span class="berkas-status">{{ $dosen->file_ijazah_s3 ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>

        <!-- Baris 4 -->
        <div class="berkas-item {{ $dosen->file_transkrip_s3 ? 'berkas-ada' : 'berkas-tidak' }}">
            Transkrip S3 <span class="berkas-status">{{ $dosen->file_transkrip_s3 ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>
        <div class="berkas-item {{ $dosen->file_jafung ? 'berkas-ada' : 'berkas-tidak' }}">
            Jafung <span class="berkas-status">{{ $dosen->file_jafung ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>

        <!-- Baris 5 -->
        <div class="berkas-item {{ $dosen->file_kk ? 'berkas-ada' : 'berkas-tidak' }}">
            Kartu Keluarga <span class="berkas-status">{{ $dosen->file_kk ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>
        <div class="berkas-item {{ $dosen->file_perjanjian_kerja ? 'berkas-ada' : 'berkas-tidak' }}">
            Perjanjian Kerja <span
                class="berkas-status">{{ $dosen->file_perjanjian_kerja ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>

        <!-- Baris 6 -->
        <div class="berkas-item {{ $dosen->file_sk_pengangkatan ? 'berkas-ada' : 'berkas-tidak' }}">
            SK Pengangkatan <span
                class="berkas-status">{{ $dosen->file_sk_pengangkatan ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>
        <div class="berkas-item {{ $dosen->file_surat_pernyataan ? 'berkas-ada' : 'berkas-tidak' }}">
            Surat Pernyataan <span
                class="berkas-status">{{ $dosen->file_surat_pernyataan ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>

        <!-- Baris 7 -->
        <div class="berkas-item {{ $dosen->file_sktp ? 'berkas-ada' : 'berkas-tidak' }}">
            SKTP <span class="berkas-status">{{ $dosen->file_sktp ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>
        <div class="berkas-item {{ $dosen->file_surat_tugas ? 'berkas-ada' : 'berkas-tidak' }}">
            Surat Tugas <span class="berkas-status">{{ $dosen->file_surat_tugas ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>

        <!-- Baris 8 -->
        <div class="berkas-item {{ $dosen->file_sk_aktif ? 'berkas-ada' : 'berkas-tidak' }}">
            SK Aktif Tridharma <span class="berkas-status">{{ $dosen->file_sk_aktif ? '✓ ADA' : '✗ TIDAK ADA' }}</span>
        </div>
    </div>

    <!-- DOKUMEN LAMA -->
    @if ($dosen->file_dokumen)
        <div class="section-title">DOKUMEN LAINNYA</div>
        <table class="biodata">
            <tr>
                <td>File Dokumen</td>
                <td>{{ $dosen->file_dokumen }}</td>
            </tr>
        </table>
    @endif

    <!-- FOOTER -->
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
        <p style="font-style: italic; font-size: 10pt;">Dokumen ini dibuat secara otomatis oleh sistem</p>
    </div>

</body>

</html>
