<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Sarpras</title>
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
        }

        /* KOP Surat - Hanya Halaman Pertama */
        .kop { 
            text-align: center; 
            border-bottom: 2px solid #000; 
            padding-bottom: 8px; 
            margin-bottom: 12px; 
            position: relative;
            page-break-after: avoid;
        }
        
        .kop img { 
            width: 70px; 
            position: absolute; 
            top: 0; 
            left: 25px; 
        }
        
        .kop h2, .kop h3 { 
            margin: 2px 0; 
            line-height: 1.3; 
        }
        
        .kop h2 { 
            font-size: 16px; 
            font-weight: bold;
        }
        
        .kop h3 { 
            font-size: 10px; 
            font-weight: normal; 
        }

        .title { 
            text-align: center; 
            font-size: 12px; 
            margin: 10px 0 15px 0; 
            text-decoration: underline; 
            font-weight: bold;
            page-break-after: avoid;
        }

        /* Tabel */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 9px;
        }
        
        thead {
            display: table-header-group; /* Header muncul di setiap halaman */
        }
        
        tbody {
            display: table-row-group;
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
            font-size: 9px;
            line-height: 1.2;
        }

        /* Lebar Kolom Disesuaikan untuk 9 Kolom */
        .col-no { width: 4%; text-align: center; }
        .col-nama { width: 18%; }
        .col-kategori { width: 10%; }
        .col-jumlah { width: 6%; text-align: center; }
        .col-kondisi { width: 8%; text-align: center; }
        .col-tanggal { width: 10%; }
        .col-lokasi { width: 12%; }
        .col-spesifikasi { width: 16%; }
        .col-keterangan { width: 16%; }

        tr { page-break-inside: avoid; }

        /* Footer */
        .footer { 
            margin-top: 25px; 
            font-size: 10px;
            page-break-inside: avoid;
        }
        
        .footer-content {
            float: right;
            text-align: center;
            width: 220px;
        }
        
        .signature { 
            margin-top: 55px;
        }

        .clear { clear: both; }
    </style>
</head>
<body>
    {{-- Kop Surat - Hanya Halaman Pertama --}}
    <div class="kop">
        <img src="{{ public_path('images/Logo-IAIT.png') }}" alt="Logo">
        <h2>INSTITUT AGAMA ISLAM TASIKMALAYA</h2>
        <h3>Jl. Noenoeng Tisnasaputra No.16 Tlp. (0265) 331501 Tasikmalaya</h3>
        <h3>email : iaitasik@iaitasik.ac.id | website : www.iaitasik.ac.id</h3>
    </div>

    <h3 class="title">
        LAPORAN DATA SARANA DAN PRASARANA<br>
        ({{ strtoupper($kondisi ?: 'SEMUA KONDISI') }})
    </h3>

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-nama">Nama Barang</th>
                <th class="col-kategori">Kategori</th>
                <th class="col-jumlah">Jml</th>
                <th class="col-kondisi">Kondisi</th>
                <th class="col-tanggal">Tgl<br>Pengadaan</th>
                <th class="col-lokasi">Lokasi Lain</th>
                <th class="col-spesifikasi">Spesifikasi</th>
                <th class="col-keterangan">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sarpras as $index => $item)
                <tr>
                    <td class="col-no">{{ $index + 1 }}</td>
                    <td class="col-nama">{{ $item->nama_barang }}</td>
                    <td class="col-kategori">{{ $item->kategori }}</td>
                    <td class="col-jumlah">{{ $item->jumlah }}</td>
                    <td class="col-kondisi">{{ $item->kondisi }}</td>
                    <td class="col-tanggal">{{ \Carbon\Carbon::parse($item->tanggal_pengadaan)->format('d/m/Y') }}</td>
                    <td class="col-lokasi">{{ $item->lokasi_lain ?? '-' }}</td>
                    <td class="col-spesifikasi">{{ $item->spesifikasi }}</td>
                    <td class="col-keterangan">{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:10px;">
                        Tidak ada data ditemukan untuk kondisi ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

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
</body>
</html>