{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Sarpras</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm 8mm;
        }

        body { 
            font-family: DejaVu Sans, sans-serif; 
            margin: 0;
            padding: 0;
            color: #000; 
            font-size: 9px;
            line-height: 1.2;
        }

        .page-break {
            page-break-after: always;
        }

        .kop { 
            text-align: center; 
            border-bottom: 2px solid #000; 
            padding-bottom: 6px; 
            margin-bottom: 8px; 
            position: relative;
            page-break-after: avoid;
        }
        
        .kop img { 
            width: 60px; 
            position: absolute; 
            top: 0; 
            left: 20px; 
        }
        
        .kop h2, .kop h3 { 
            margin: 1px 0; 
            line-height: 1.2; 
        }
        
        .kop h2 { 
            font-size: 14px; 
            font-weight: bold;
        }
        
        .kop h3 { 
            font-size: 9px; 
            font-weight: normal; 
        }

        .title { 
            text-align: center; 
            font-size: 11px; 
            margin: 8px 0 10px 0; 
            text-decoration: underline; 
            font-weight: bold;
            page-break-after: avoid;
        }

        .filter-info {
            background-color: #f0f8ff;
            border: 1px solid #b8daff;
            padding: 6px;
            margin-bottom: 8px;
            border-radius: 3px;
            font-size: 8px;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 7px;
            page-break-inside: auto;
        }
        
        thead {
            display: table-header-group;
        }
        
        tbody {
            display: table-row-group;
        }
        
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        
        th, td { 
            border: 0.5px solid #000; 
            padding: 3px 4px; 
            vertical-align: top; 
            text-align: left;
            word-wrap: break-word;
        }
        
        th { 
            background-color: #e8e8e8; 
            text-align: center;
            font-weight: bold;
            font-size: 7px;
            line-height: 1.1;
            padding: 4px 3px;
        }

        .col-no { width: 2%; text-align: center; }
        .col-fakultas { width: 8%; }
        .col-prodi { width: 8%; }
        .col-ruangan { width: 8%; }
        .col-nama { width: 10%; }
        .col-kategori { width: 6%; }
        .col-merk { width: 6%; }
        .col-jumlah { width: 3%; text-align: center; }
        .col-harga { width: 6%; text-align: right; }
        .col-kondisi { width: 5%; text-align: center; }
        .col-tanggal { width: 5%; }
        .col-kode { width: 6%; }
        .col-sumber { width: 4%; }
        .col-spesifikasi { width: 15%; }
        .col-keterangan { width: 8%; }

        .footer { 
            margin-top: 15px; 
            font-size: 8px;
            page-break-inside: avoid;
        }
        
        .footer-content {
            float: right;
            text-align: center;
            width: 180px;
        }
        
        .signature { 
            margin-top: 40px;
        }

        .clear { clear: both; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .summary-total {
            background-color: #e7f3ff;
            border: 1px solid #b8daff;
            padding: 5px;
            margin-top: 8px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            page-break-inside: avoid;
        }

        .group-header {
            background-color: #d4edda;
            font-weight: bold;
            border: 0.5px solid #000;
            padding: 4px;
            font-size: 8px;
        }

        /* Alternating row colors for better readability */
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop">
        <img src="{{ public_path('images/Logo-IAIT.png') }}" alt="Logo">
        <h2>INSTITUT AGAMA ISLAM TASIKMALAYA</h2>
        <h3>Jl. Noenoeng Tisnasaputra No.16 Tlp. (0265) 331501 Tasikmalaya</h3>
        <h3>email : iaitasik@iaitasik.ac.id | website : www.iaitasik.ac.id</h3>
    </div>

    <h3 class="title">
        LAPORAN DATA SARANA DAN PRASARANA
    </h3>

    <!-- Informasi Filter -->
    <div class="filter-info">
        <strong>FILTER YANG DIGUNAKAN:</strong><br>
        <strong>Kondisi:</strong> {{ $kondisi ?? 'Semua Kondisi' }} | 
        <strong>Pencarian:</strong> {{ $search ?? 'Tidak Ada' }} | 
        <strong>Fakultas:</strong> 
        @if($fakultasId)
            {{ \App\Models\Fakultas::find($fakultasId)->nama_fakultas ?? 'Semua Fakultas' }}
        @else
            Semua Fakultas
        @endif
    </div>

    <!-- Tabel Utama -->
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-fakultas">Fakultas</th>
                <th class="col-prodi">Program Studi</th>
                <th class="col-ruangan">Ruangan</th>
                <th class="col-nama">Nama Barang</th>
                <th class="col-kategori">Kategori</th>
                <th class="col-merk">Merk</th>
                <th class="col-jumlah">Jml</th>
                <th class="col-harga">Harga (Rp)</th>
                <th class="col-kondisi">Kondisi</th>
                <th class="col-tanggal">Tgl Pengadaan</th>
                <th class="col-kode">Kode/Seri</th>
                <th class="col-sumber">Sumber</th>
                <th class="col-spesifikasi">Spesifikasi</th>
                <th class="col-keterangan">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1;
                $totalBarang = 0;
                $totalUnit = 0;
                $totalNilai = 0;
                $currentFakultas = null;
            @endphp

            @foreach($dataPerRuangan as $ruanganId => $barangRuangan)
                @foreach($barangRuangan as $item)
                    @php
                        $fakultas = $item->prodi->fakultas->nama_fakultas ?? 'Unit Umum';
                        $prodi = $item->prodi->nama_prodi ?? 'Unit Umum';
                        
                        // Hitung totals
                        $totalBarang++;
                        $totalUnit += $item->jumlah;
                        $totalNilai += $item->harga;
                    @endphp

                    <tr>
                        <td class="col-no">{{ $counter++ }}</td>
                        <td class="col-fakultas">{{ $fakultas }}</td>
                        <td class="col-prodi">{{ $prodi }}</td>
                        <td class="col-ruangan">
                            <div><strong>{{ $item->nama_ruangan }}</strong></div>
                            <div style="font-size: 6px; color: #666;">{{ $item->kategori_ruangan }}</div>
                        </td>
                        <td class="col-nama">{{ $item->nama_barang }}</td>
                        <td class="col-kategori">{{ $item->kategori_barang }}</td>
                        <td class="col-merk">{{ $item->merk_barang ?? '-' }}</td>
                        <td class="col-jumlah">{{ $item->jumlah }} {{ $item->satuan }}</td>
                        <td class="col-harga text-right">
                            @if($item->harga)
                                {{ number_format($item->harga, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="col-kondisi">{{ $item->kondisi }}</td>
                        <td class="col-tanggal">{{ \Carbon\Carbon::parse($item->tanggal_pengadaan)->format('d/m/Y') }}</td>
                        <td class="col-kode">{{ $item->kode_seri }}</td>
                        <td class="col-sumber">{{ $item->sumber }}</td>
                        <td class="col-spesifikasi" style="font-size: 6px;">{{ Str::limit($item->spesifikasi, 100) }}</td>
                        <td class="col-keterangan">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            @endforeach

            @if($counter == 1)
                <tr>
                    <td colspan="15" class="text-center" style="padding: 20px;">
                        Tidak ada data untuk filter yang dipilih.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Summary Total -->
    @if($counter > 1)
    <div class="summary-total">
        <strong>RINGKASAN KESELURUHAN:</strong><br>
        <strong>Total Barang:</strong> {{ $totalBarang }} item | 
        <strong>Total Unit:</strong> {{ $totalUnit }} unit | 
        <strong>Total Nilai:</strong> Rp {{ number_format($totalNilai, 0, ',', '.') }} |
        <strong>Jumlah Ruangan:</strong> {{ count($dataPerRuangan) }} ruangan
    </div>

    <!-- Breakdown by Condition -->
    <div class="summary-total" style="background-color: #fff3cd; border-color: #ffeaa7; margin-top: 5px;">
        <strong>BREAKDOWN BERDASARKAN KONDISI:</strong><br>
        @php
            $kondisiCounts = [];
            foreach($dataPerRuangan as $barangRuangan) {
                foreach($barangRuangan as $item) {
                    $kondisi = $item->kondisi;
                    if (!isset($kondisiCounts[$kondisi])) {
                        $kondisiCounts[$kondisi] = 0;
                    }
                    $kondisiCounts[$kondisi]++;
                }
            }
        @endphp
        
        @foreach($kondisiCounts as $kondisi => $count)
            <strong>{{ $kondisi }}:</strong> {{ $count }} barang
            @if(!$loop->last) | @endif
        @endforeach
    </div>
    @endif

    <!-- Footer dan Tanda Tangan -->
    <div class="footer">
        <div class="footer-content">
            <p>Tasikmalaya, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <p><strong>Superadmin / Admin</strong></p>
            <div class="signature">
                <p>__________________________</p>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <!-- Page number -->
    <div style="position: fixed; bottom: 10px; right: 10px; font-size: 8px; color: #666;">
        Halaman 1
    </div>
</body>
</html> --}}