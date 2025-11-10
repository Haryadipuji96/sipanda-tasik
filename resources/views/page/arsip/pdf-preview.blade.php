<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Arsip</title>
    <style>
        @page {
            size: A4 landscape;
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
            display: table-header-group;
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

        /* Lebar Kolom */
        .col-no { width: 3%; text-align: center; }
        .col-judul { width: 20%; }
        .col-nomor { width: 12%; }
        .col-tanggal { width: 8%; text-align: center; }
        .col-tahun { width: 5%; text-align: center; }
        .col-kategori { width: 12%; }
        .col-prodi { width: 15%; }
        .col-keterangan { width: 15%; }
        .col-file { width: 10%; }

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

        .summary {
            margin-top: 15px;
            padding: 8px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-size: 9px;
        }
    </style>
</head>
<body>
    {{-- Kop Surat --}}
    <div class="kop">
        <img src="{{ public_path('images/Logo-IAIT.png') }}" alt="Logo">
        <h2>INSTITUT AGAMA ISLAM TASIKMALAYA</h2>
        <h3>Jl. Noenoeng Tisnasaputra No.16 Tlp. (0265) 331501 Tasikmalaya</h3>
        <h3>email : iaitasik@iaitasik.ac.id | website : www.iaitasik.ac.id</h3>
    </div>

    <h3 class="title">
        LAPORAN DATA ARSIP DOKUMEN
    </h3>

    {{-- Info Filter --}}
    @if(request()->has('search') || request()->has('kategori') || request()->has('prodi') || request()->has('tahun'))
    <div style="margin-bottom: 15px; padding: 8px; background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 4px; font-size: 9px;">
        <strong>Filter yang diterapkan:</strong>
        <div style="margin-top: 4px;">
            @if(request('search'))
            <span style="background-color: #dbeafe; color: #1e40af; padding: 2px 6px; border-radius: 10px; margin-right: 5px; font-size: 8px;">
                Pencarian: "{{ request('search') }}"
            </span>
            @endif
            @if(request('kategori'))
            <span style="background-color: #dbeafe; color: #1e40af; padding: 2px 6px; border-radius: 10px; margin-right: 5px; font-size: 8px;">
                Kategori: {{ request('kategori') }}
            </span>
            @endif
            @if(request('prodi'))
            <span style="background-color: #dbeafe; color: #1e40af; padding: 2px 6px; border-radius: 10px; margin-right: 5px; font-size: 8px;">
                Prodi: {{ request('prodi') }}
            </span>
            @endif
            @if(request('tahun'))
            <span style="background-color: #dbeafe; color: #1e40af; padding: 2px 6px; border-radius: 10px; margin-right: 5px; font-size: 8px;">
                Tahun: {{ request('tahun') }}
            </span>
            @endif
        </div>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-judul">Judul Dokumen</th>
                <th class="col-nomor">Nomor Dokumen</th>
                <th class="col-tanggal">Tanggal</th>
                <th class="col-tahun">Tahun</th>
                <th class="col-kategori">Kategori</th>
                <th class="col-prodi">Program Studi</th>
                <th class="col-keterangan">Keterangan</th>
               
            </tr>
        </thead>
        <tbody>
            @forelse($arsip as $index => $a)
                <tr>
                    <td class="col-no">{{ $index + 1 }}</td>
                    <td class="col-judul">{{ $a->judul_dokumen }}</td>
                    <td class="col-nomor">{{ $a->nomor_dokumen ?? '-' }}</td>
                    <td class="col-tanggal">
                        {{ $a->tanggal_dokumen ? \Carbon\Carbon::parse($a->tanggal_dokumen)->format('d-m-Y') : '-' }}
                    </td>
                    <td class="col-tahun">{{ $a->tahun ?? '-' }}</td>
                    <td class="col-kategori">{{ $a->kategori->nama_kategori ?? '-' }}</td>
                    <td class="col-prodi">{{ $a->prodi->nama_prodi ?? '-' }}</td>
                    <td class="col-keterangan">{{ $a->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:15px; font-style: italic;">
                        Tidak ada data arsip ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Summary --}}
    @if($arsip->count() > 0)
    <div class="summary">
        <strong>Ringkasan:</strong> Total <strong>{{ $arsip->count() }}</strong> dokumen arsip
        @if(request('tahun'))
        | Tahun: <strong>{{ request('tahun') }}</strong>
        @endif
        @if(request('kategori'))
        | Kategori: <strong>{{ request('kategori') }}</strong>
        @endif
    </div>
    @endif

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