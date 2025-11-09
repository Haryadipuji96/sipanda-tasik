<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lengkap Tenaga Pendidik - {{ $tenagaPendidik->nama_tendik }}</title>
    <style>
        @page { margin: 2cm 1.5cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; background-color: #fff; }
        
        /* === KOP SURAT === */
        .kop { display: flex; align-items: center; justify-content: center; position: relative; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 25px; }
        .kop img { width: 75px; position: absolute; left: 20px; top: 10px; }
        .kop-text { text-align: center; }
        .kop-text h2 { margin: 0; font-size: 16pt; font-weight: bold; }
        .kop-text h3 { margin: 2px 0; font-size: 11pt; font-weight: normal; }

        /* === JUDUL === */
        .judul { text-align: center; font-size: 14pt; font-weight: bold; text-decoration: underline; margin: 25px 0 20px; text-transform: uppercase; }

        /* === SECTION TITLE === */
        .section-title { font-size: 12pt; font-weight: bold; background-color: #efefef; padding: 6px 10px; margin-top: 25px; margin-bottom: 10px; border-left: 4px solid #333; }

        /* === TABEL BIODATA === */
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table.biodata td { padding: 6px 10px; border: 1px solid #000; vertical-align: top; }
        table.biodata td:first-child { width: 35%; font-weight: bold; background-color: #f9f9f9; }

        /* === TABEL RIWAYAT GOLONGAN === */
        table.golongan th { background-color: #dcdcdc; font-weight: bold; padding: 8px; border: 1px solid #000; text-align: center; }
        table.golongan td { padding: 6px 8px; border: 1px solid #000; text-align: center; }

        /* === FOOTER === */
        .footer { margin-top: 40px; text-align: right; font-size: 11pt; border-top: 1px solid #ccc; padding-top: 10px; }
        .footer p { margin: 3px 0; }

        /* === STATUS BADGE === */
        .status-badge { 
            display: inline-block; 
            padding: 2px 8px; 
            border-radius: 10px; 
            font-size: 10pt; 
            font-weight: bold; 
            text-align: center;
        }
        .status-pns { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .status-honorer { background-color: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .status-kontrak { background-color: #cce7ff; color: #004085; border: 1px solid #b3d7ff; }
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
        DATA LENGKAP TENAGA PENDIDIK
    </div>

    <!-- DATA PRIBADI -->
    <div class="section-title">DATA PRIBADI</div>
    <table class="biodata">
        <tr>
            <td>Nama Lengkap</td>
            <td>
                {{ $tenagaPendidik->gelar_depan ? $tenagaPendidik->gelar_depan . ' ' : '' }}
                {{ $tenagaPendidik->nama_tendik }}
                {{ $tenagaPendidik->gelar_belakang ? ', ' . $tenagaPendidik->gelar_belakang : '' }}
            </td>
        </tr>
        <tr>
            <td>Program Studi</td>
            <td>{{ $tenagaPendidik->prodi->nama_prodi ?? '-' }}</td>
        </tr>
        <tr>
            <td>Status Kepegawaian</td>
            <td>
                @if($tenagaPendidik->status_kepegawaian == 'PNS')
                    <span class="status-badge status-pns">PNS</span>
                @elseif($tenagaPendidik->status_kepegawaian == 'Honorer')
                    <span class="status-badge status-honorer">HONORER</span>
                @elseif($tenagaPendidik->status_kepegawaian == 'Kontrak')
                    <span class="status-badge status-kontrak">KONTRAK</span>
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>
                @if($tenagaPendidik->jenis_kelamin == 'laki-laki')
                    Laki-laki
                @elseif($tenagaPendidik->jenis_kelamin == 'perempuan')
                    Perempuan
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td>Tempat Lahir</td>
            <td>{{ $tenagaPendidik->tempat_lahir ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>{{ $tenagaPendidik->tanggal_lahir ? $tenagaPendidik->tanggal_lahir->format('d/m/Y') : '-' }}</td>
        </tr>
        <tr>
            <td>TMT Kerja</td>
            <td>{{ $tenagaPendidik->tmt_kerja ? $tenagaPendidik->tmt_kerja->format('d/m/Y') : '-' }}</td>
        </tr>
        <tr>
            <td>NIP/NIK</td>
            <td>{{ $tenagaPendidik->nip ?? '-' }}</td>
        </tr>
    </table>

    <!-- KONTAK DAN ALAMAT -->
    <div class="section-title">KONTAK DAN ALAMAT</div>
    <table class="biodata">
        <tr>
            <td>Email</td>
            <td>{{ $tenagaPendidik->email ?? '-' }}</td>
        </tr>
        <tr>
            <td>No. Telepon/HP</td>
            <td>{{ $tenagaPendidik->no_hp ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>{{ $tenagaPendidik->alamat ?? '-' }}</td>
        </tr>
    </table>

    <!-- RIWAYAT GOLONGAN -->
    <div class="section-title">RIWAYAT GOLONGAN</div>
    <table class="golongan">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Golongan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $golonganArray = [];
                if (is_array($tenagaPendidik->golongan_array)) {
                    $golonganArray = $tenagaPendidik->golongan_array;
                } else {
                    $decoded = json_decode($tenagaPendidik->golongan_array, true);
                    $golonganArray = is_array($decoded) ? $decoded : [];
                }
            @endphp
            
            @forelse($golonganArray as $index => $gol)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $gol['tahun'] ?? '-' }}</td>
                    <td>{{ $gol['golongan'] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center; font-style:italic; color:#666;">
                        Belum ada data riwayat golongan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- DOKUMEN -->
    @if($tenagaPendidik->file)
    <div class="section-title">DOKUMEN</div>
    <table class="biodata">
        <tr>
            <td>File Dokumen</td>
            <td>{{ $tenagaPendidik->file }}</td>
        </tr>
    </table>
    @endif

    <!-- KETERANGAN -->
    @if($tenagaPendidik->keterangan)
        <div class="section-title">KETERANGAN</div>
        <p style="text-align: justify; line-height: 1.6;">{{ $tenagaPendidik->keterangan }}</p>
    @endif

    <!-- FOOTER -->
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
        <p style="font-style: italic; font-size: 10pt;">Dokumen ini dibuat secara otomatis oleh sistem</p>
    </div>

</body>

</html>