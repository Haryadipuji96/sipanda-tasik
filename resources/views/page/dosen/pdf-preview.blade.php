<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Dosen</title>
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

        .kop h2,
        .kop h3 {
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
            font-size: 7px;
        }

        thead {
            display: table-header-group;
        }

        tbody {
            display: table-row-group;
        }

        th,
        td {
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
            line-height: 1.2;
        }

        /* Lebar Kolom */
        .col-no {
            width: 2%;
            text-align: center;
        }

        .col-nama {
            width: 12%;
        }

        .col-prodi {
            width: 10%;
        }

        .col-ttl {
            width: 8%;
        }

        .col-nidn {
            width: 6%;
        }

        .col-pendidikan {
            width: 8%;
        }

        .col-jabatan {
            width: 8%;
        }

        .col-tmt {
            width: 6%;
            text-align: center;
        }

        .col-mk-thn {
            width: 3%;
            text-align: center;
        }

        .col-mk-bln {
            width: 3%;
            text-align: center;
        }

        .col-pangkat {
            width: 7%;
        }

        .col-sertifikasi {
            width: 5%;
            text-align: center;
        }

        .col-inpasing {
            width: 5%;
            text-align: center;
        }

        tr {
            page-break-inside: avoid;
        }

        /* Status Badge */
        .status-badge {
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 6px;
            font-weight: bold;
            display: inline-block;
        }

        .status-sudah {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-belum {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Footer */
        .footer {
            margin-top: 20px;
            font-size: 9px;
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

        .clear {
            clear: both;
        }

        .summary {
            margin-top: 12px;
            padding: 6px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-size: 8px;
        }

        /* Info Filter */
        .filter-info {
            margin-bottom: 12px;
            padding: 6px;
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 4px;
            font-size: 8px;
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
        LAPORAN DATA DOSEN
    </h3>

    {{-- Info Filter --}}
    @if (request()->has('search') || request()->has('prodi') || request()->has('sertifikasi') || request()->has('inpasing'))
        <div class="filter-info">
            <strong>Filter yang diterapkan:</strong>
            <div style="margin-top: 3px;">
                @if (request('search'))
                    <span
                        style="background-color: #dbeafe; color: #1e40af; padding: 1px 5px; border-radius: 8px; margin-right: 4px; font-size: 7px;">
                        Pencarian: "{{ request('search') }}"
                    </span>
                @endif
                @if (request('prodi'))
                    <span
                        style="background-color: #dbeafe; color: #1e40af; padding: 1px 5px; border-radius: 8px; margin-right: 4px; font-size: 7px;">
                        Prodi: {{ request('prodi') }}
                    </span>
                @endif
                @if (request('sertifikasi'))
                    <span
                        style="background-color: #dbeafe; color: #1e40af; padding: 1px 5px; border-radius: 8px; margin-right: 4px; font-size: 7px;">
                        Sertifikasi: {{ request('sertifikasi') }}
                    </span>
                @endif
                @if (request('inpasing'))
                    <span
                        style="background-color: #dbeafe; color: #1e40af; padding: 1px 5px; border-radius: 8px; margin-right: 4px; font-size: 7px;">
                        Inpasing: {{ request('inpasing') }}
                    </span>
                @endif
            </div>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-nama">Nama</th>
                <th class="col-prodi">Program Studi</th>
                <th class="col-ttl">Tempat/Tgl Lahir</th>
                <th class="col-nidn">NIDN</th>
                <th class="col-pendidikan">Pendidikan</th>
                <th class="col-jabatan">Jabatan</th>
                <th class="col-tmt">TMT Kerja</th>
                <th class="col-mk-thn">MK Thn</th>
                <th class="col-mk-bln">MK Bln</th>
                <th class="col-pangkat">Pangkat/Gol</th>
                <th class="col-sertifikasi">Sertifikasi</th>
                <th class="col-inpasing">Inpasing</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dosen as $index => $d)
                <tr>
                    <td class="col-no">{{ $index + 1 }}</td>
                    <td class="col-nama">{{ $d->nama }}</td>
                    <td class="col-prodi">{{ $d->prodi->nama_prodi ?? '-' }}</td>
                    <td class="col-ttl">{{ $d->tempat_tanggal_lahir ?? '-' }}</td>
                    <td class="col-nidn">{{ $d->nik ?? '-' }}</td>
                    <td class="col-pendidikan">{{ $d->pendidikan_terakhir ?? '-' }}</td>
                    <td class="col-jabatan">{{ $d->jabatan ?? '-' }}</td>
                    <td class="col-tmt">
                        {{ $d->tmt_kerja ? \Carbon\Carbon::parse($d->tmt_kerja)->format('d-m-Y') : '-' }}
                    </td>
                    <td class="col-mk-thn">{{ $d->masa_kerja_tahun ?? 0 }}</td>
                    <td class="col-mk-bln">{{ $d->masa_kerja_bulan ?? 0 }}</td>
                    <td class="col-pangkat">{{ $d->pangkat_golongan ?? '-' }}</td>
                    <td class="col-sertifikasi">
                        <strong>{{ $d->sertifikasi }}</strong>
                    </td>
                    <td class="col-inpasing">
                        <strong>{{ $d->inpasing }}</strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="13" style="text-align:center; padding:12px; font-style: italic;">
                        Tidak ada data dosen ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Summary --}}
    @if ($dosen->count() > 0)
        <div class="summary">
            <strong>Ringkasan:</strong> Total <strong>{{ $dosen->count() }}</strong> dosen
            @if (request('prodi'))
                | Prodi: <strong>{{ request('prodi') }}</strong>
            @endif
            @if (request('sertifikasi'))
                | Sertifikasi: <strong>{{ request('sertifikasi') }}</strong>
                ({{ $dosen->where('sertifikasi', request('sertifikasi'))->count() }})
            @endif
            @if (request('inpasing'))
                | Inpasing: <strong>{{ request('inpasing') }}</strong>
                ({{ $dosen->where('inpasing', request('inpasing'))->count() }})
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
