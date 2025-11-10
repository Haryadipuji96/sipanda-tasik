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
            font-size: 8px;
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
            font-size: 8px;
            line-height: 1.2;
        }

        /* Lebar Kolom Disesuaikan untuk 12 Kolom */
        .col-no { width: 3%; text-align: center; }
        .col-nama { width: 14%; }
        .col-prodi { width: 10%; }
        .col-kategori { width: 8%; }
        .col-jumlah { width: 4%; text-align: center; }
        .col-kondisi { width: 6%; text-align: center; }
        .col-tanggal { width: 7%; }
        .col-kode { width: 7%; }
        .col-sumber { width: 8%; }
        .col-lokasi { width: 10%; }
        .col-spesifikasi { width: 13%; }
        .col-keterangan { width: 10%; }

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
        
        /* Kondisi styling */
        .kondisi-baik {
            background-color: #d1fae5;
            color: #065f46;
            padding: 2px 4px;
            border-radius: 2px;
            font-weight: bold;
        }
        
        .kondisi-rusak-ringan {
            background-color: #fef3c7;
            color: #92400e;
            padding: 2px 4px;
            border-radius: 2px;
            font-weight: bold;
        }
        
        .kondisi-rusak-berat {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 2px 4px;
            border-radius: 2px;
            font-weight: bold;
        }
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
                <th class="col-prodi">Prodi</th>
                <th class="col-kategori">Kategori</th>
                <th class="col-jumlah">Jml</th>
                <th class="col-kondisi">Kondisi</th>
                <th class="col-tanggal">Tgl<br>Pengadaan</th>
                <th class="col-kode">Kode/Seri</th>
                <th class="col-sumber">Sumber</th>
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
                    <td class="col-prodi">{{ $item->prodi->nama_prodi ?? '-' }}</td>
                    <td class="col-kategori">{{ $item->kategori }}</td>
                    <td class="col-jumlah">{{ $item->jumlah }}</td>
                    <td class="col-kondisi">
                        @if($item->kondisi == 'Baik')
                            <span class="kondisi-baik">{{ $item->kondisi }}</span>
                        @elseif($item->kondisi == 'Rusak Ringan')
                            <span class="kondisi-rusak-ringan">{{ $item->kondisi }}</span>
                        @elseif($item->kondisi == 'Rusak Berat')
                            <span class="kondisi-rusak-berat">{{ $item->kondisi }}</span>
                        @else
                            {{ $item->kondisi }}
                        @endif
                    </td>
                    <td class="col-tanggal">{{ \Carbon\Carbon::parse($item->tanggal_pengadaan)->format('d/m/Y') }}</td>
                    <td class="col-kode">{{ $item->kode_seri }}</td>
                    <td class="col-sumber">{{ $item->sumber }}</td>
                    <td class="col-lokasi">{{ $item->lokasi_lain ?? '-' }}</td>
                    <td class="col-spesifikasi">{{ $item->spesifikasi }}</td>
                    <td class="col-keterangan">{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" style="text-align:center; padding:10px;">
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