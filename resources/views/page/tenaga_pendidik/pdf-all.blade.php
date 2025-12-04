<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Tenaga Pendidik - IAIT</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 10px;
            color: #000;
            margin: 30px;
            line-height: 1.3;
        }

        /* === KOP SURAT === */
        .kop {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border-bottom: 2px solid #000;
            margin-bottom: 8px;
            padding: 10px 0;
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
            left: 10px;
            top: 10px;
            width: 45px;
            height: 45px;
            object-fit: contain;
        }

        .kop-text {
            text-align: center;
            flex: 1;
            margin-left: 60px;
            /* Sesuaikan dengan lebar logo + margin */
            margin-right: 10px;
        }

        .kop-text h1 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text p {
            margin: 1px 0;
            font-size: 9px;
        }

        /* === INFORMASI DOKUMEN === */
        .document-info {
            text-align: center;
            margin-top: 12px;
            margin-bottom: 12px;
        }

        .document-info strong {
            font-size: 10px;
            text-transform: uppercase;
        }

        /* === TABEL === */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 5px;
            vertical-align: top;
        }

        th {
            text-align: center;
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .text-center {
            text-align: center;
        }

        /* === SUMMARY STATISTIK === */
        .summary {
            margin-top: 15px;
            padding: 8px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            font-size: 9px;
        }

        .summary-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .summary-item {
            text-align: left;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .summary-number {
            font-weight: bold;
            font-size: 11px;
            margin-right: 5px;
        }

        .summary-label {
            font-size: 8px;
            color: #666;
        }

        /* === FOOTER === */
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            border-top: 1px solid #000;
            padding-top: 4px;
        }

        .no-data {
            text-align: center;
            border: 1px solid #000;
            padding: 30px;
            font-style: italic;
            font-size: 11px;
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <!-- KOP SURAT -->
    <div class="kop">
        <img class="logo" src="{{ public_path('images/Logo-IAIT.png') }}" alt="Logo IAIT">
        <div class="kop-text">
            <h1>INSTITUT AGAMA ISLAM TASIKMALAYA</h1>
            <p>Jl. Noenoeng Tisnasaputra No.16, Kahuripan, Tawang, Tasikmalaya</p>
            <p>Telepon: (0265) 331501 | Email: iaitasik@iaitasik.ac.id | Website: www.iaitasik.ac.id</p>
        </div>
    </div>

    <!-- INFORMASI DOKUMEN -->
    <div class="document-info">
        <strong>DATA TENAGA KEPENDIDIKAN</strong><br>
        Dicetak pada: {{ date('d-m-Y H:i:s') }}
    </div>

    @if (isset($tenaga) && $tenaga->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="3%">NO</th>
                    <th width="15%">NAMA LENGKAP</th>
                    <th width="12%">POSISI/JABATAN</th>
                    <th width="8%">NIP</th>
                    <th width="10%">STATUS</th>
                    <th width="4%">JK</th>
                    {{-- <th width="10%">PROGRAM STUDI</th>
                    <th width="10%">FAKULTAS</th> --}}
                    <th width="8%">TEMPAT LAHIR</th>
                    <th width="6%">TGL LAHIR</th>
                    <th width="6%">TMT KERJA</th>
                    <th width="6%">MASA KERJA</th>
                    <th width="8%">MASA KERJA GOL</th>
                    <th width="5%">GOL</th>
                    <th width="6%">KNP YAD</th>
                    <th width="8%">PENDIDIKAN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tenaga as $index => $tendik)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <strong>
                                {{ $tendik->gelar_depan ? $tendik->gelar_depan . ' ' : '' }}
                                {{ $tendik->nama_tendik }}
                                {{ $tendik->gelar_belakang ? ', ' . $tendik->gelar_belakang : '' }}
                            </strong>
                        </td>
                        <td>{{ $tendik->jabatan_struktural ?? 'Umum' }}</td>
                        <td class="text-center">{{ $tendik->nip ?? '-' }}</td>
                        <td class="text-center">
                            @if ($tendik->status_kepegawaian == 'PNS')
                                PNS
                            @elseif($tendik->status_kepegawaian == 'Non PNS Tetap')
                                NON PNS TETAP
                            @elseif($tendik->status_kepegawaian == 'Non PNS Tidak Tetap')
                                NON PNS TDK TETAP
                            @else
                                {{ $tendik->status_kepegawaian }}
                            @endif
                        </td>
                        <td class="text-center">{{ $tendik->jenis_kelamin == 'laki-laki' ? 'L' : 'P' }}</td>
                        {{-- <td>{{ $tendik->prodi->nama_prodi ?? 'Umum' }}</td>
                        <td>{{ $tendik->prodi->fakultas->nama_fakultas ?? '-' }}</td> --}}
                        <td>{{ $tendik->tempat_lahir ?? '-' }}</td>
                        <td class="text-center">
                            {{ $tendik->tanggal_lahir ? \Carbon\Carbon::parse($tendik->tanggal_lahir)->format('d-m-Y') : '-' }}
                        </td>
                        <td class="text-center">
                            {{ $tendik->tmt_kerja ? \Carbon\Carbon::parse($tendik->tmt_kerja)->format('d-m-Y') : '-' }}
                        </td>
                        <!-- Masa Kerja -->
                        <td class="text-center">
                            @if ($tendik->masa_kerja_tahun || $tendik->masa_kerja_bulan)
                                {{ $tendik->masa_kerja_tahun ?? '0' }}T<br>
                                {{ $tendik->masa_kerja_bulan ?? '0' }}B
                            @else
                                -
                            @endif
                        </td>

                        <!-- Masa Kerja Golongan -->
                        <td class="text-center">
                            @if ($tendik->masa_kerja_golongan_tahun || $tendik->masa_kerja_golongan_bulan)
                                {{ $tendik->masa_kerja_golongan_tahun ?? '0' }}T<br>
                                {{ $tendik->masa_kerja_golongan_bulan ?? '0' }}B
                            @else
                                -
                            @endif
                        </td>

                        <!-- Golongan (Gol) -->
                        <td class="text-center">{{ $tendik->gol ?? '-' }}</td>

                        <!-- KNP YAD -->
                        <td class="text-center">
                            {{ $tendik->knp_yad ? \Carbon\Carbon::parse($tendik->knp_yad)->format('d-m-Y') : '-' }}
                        </td>
                        <td class="text-center">{{ $tendik->pendidikan_terakhir ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- SUMMARY STATISTIK - DI BAWAH TABLE -->
        <div class="summary">
            <div class="summary-container">
                <div class="summary-item">
                    <span class="summary-number">{{ $tenaga->count() }}</span>
                    <span class="summary-label">TOTAL TENAGA</span>
                </div>

                <div class="summary-item">
                    <span class="summary-number">{{ $tenaga->where('status_kepegawaian', 'KONTRAK')->count() }}</span>
                    <span class="summary-label">KONTRAK</span>
                </div>
                <div class="summary-item">
                    <span class="summary-number">{{ $tenaga->where('status_kepegawaian', 'TETAP')->count() }}</span>
                    <span class="summary-label">TETAP</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <strong>DOKUMEN RESMI - INSTITUT AGAMA ISLAM TASIKMALAYA</strong><br>
            Sistem Informasi Akademik | Hal. 1 | Total: {{ $tenaga->count() }} Data
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
