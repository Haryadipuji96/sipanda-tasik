<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Sarpras Per Ruangan</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 12mm;
        }

        body { 
            font-family: DejaVu Sans, sans-serif; 
            margin: 0;
            padding: 0;
            color: #000; 
            font-size: 10px;
            line-height: 1.2;
        }

        .kop { 
            text-align: center; 
            border-bottom: 2px solid #000; 
            padding-bottom: 6px; 
            margin-bottom: 8px; 
            position: relative;
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
        }

        .ruangan-info {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 6px;
            margin-bottom: 8px;
            border-radius: 3px;
            font-size: 9px;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 8px;
        }
        
        th, td { 
            border: 0.5px solid #000; 
            padding: 4px 5px; 
            vertical-align: top; 
            text-align: left;
            word-wrap: break-word;
        }
        
        th { 
            background-color: #e8e8e8; 
            text-align: center;
            font-weight: bold;
            font-size: 8px;
            padding: 5px 4px;
        }

        .col-no { width: 3%; text-align: center; }
        .col-nama { width: 15%; }
        .col-kategori { width: 10%; }
        .col-merk { width: 8%; }
        .col-jumlah { width: 5%; text-align: center; }
        .col-harga { width: 8%; text-align: right; }
        .col-kondisi { width: 6%; text-align: center; }
        .col-tanggal { width: 7%; }
        .col-kode { width: 8%; }
        .col-sumber { width: 6%; }
        .col-spesifikasi { width: 20%; }
        .col-keterangan { width: 10%; }

        .footer { 
            margin-top: 15px; 
            font-size: 9px;
        }
        
        .footer-content {
            float: right;
            text-align: center;
            width: 200px;
        }
        
        .signature { 
            margin-top: 50px;
        }

        .clear { clear: both; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .summary-total {
            background-color: #e7f3ff;
            border: 1px solid #b8daff;
            padding: 6px;
            margin-top: 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        /* Alternating row colors */
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
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
        LAPORAN DATA SARANA DAN PRASARANA<br>
        PER RUANGAN
    </h3>

    <!-- Informasi Ruangan -->
    <div class="ruangan-info">
        <strong>Ruangan:</strong> {{ $namaRuangan }}<br>
        @if($prodi)
            <strong>Program Studi:</strong> {{ $prodi->nama_prodi }}<br>
            <strong>Fakultas:</strong> {{ $prodi->fakultas->nama_fakultas ?? '-' }}
        @else
            <strong>Lokasi:</strong> Unit Umum
        @endif
    </div>

    <!-- Tabel Barang -->
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
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
            @foreach($sarpras as $index => $item)
                <tr>
                    <td class="col-no">{{ $index + 1 }}</td>
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
                    <td class="col-spesifikasi">{{ $item->spesifikasi }}</td>
                    <td class="col-keterangan">{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary-total">
        <strong>RINGKASAN RUANGAN {{ strtoupper($namaRuangan) }}:</strong><br>
        <strong>Total Barang:</strong> {{ $totalBarang }} item | 
        <strong>Total Unit:</strong> {{ $totalUnit }} unit | 
        <strong>Total Nilai:</strong> Rp {{ number_format($totalNilai, 0, ',', '.') }}
    </div>

    <!-- Breakdown by Condition -->
    <div class="summary-total" style="background-color: #fff3cd; border-color: #ffeaa7; margin-top: 5px;">
        <strong>BREAKDOWN BERDASARKAN KONDISI:</strong><br>
        @php
            $kondisiCounts = [];
            foreach($sarpras as $item) {
                $kondisi = $item->kondisi;
                if (!isset($kondisiCounts[$kondisi])) {
                    $kondisiCounts[$kondisi] = 0;
                }
                $kondisiCounts[$kondisi]++;
            }
        @endphp
        
        @foreach($kondisiCounts as $kondisi => $count)
            <strong>{{ $kondisi }}:</strong> {{ $count }} barang
            @if(!$loop->last) | @endif
        @endforeach
    </div>

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
</html>