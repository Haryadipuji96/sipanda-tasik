<x-app-layout>
<div class="py-8 px-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Detail Tenaga Pendidik</h2>

    <div class="bg-white shadow p-4 rounded mb-4">
        <p><strong>Nama:</strong> {{ $tenagaPendidik->nama_tendik }}</p>
        <p><strong>Prodi:</strong> {{ $tenagaPendidik->prodi->nama_prodi ?? '-' }}</p>
        <p><strong>NIP:</strong> {{ $tenagaPendidik->nip }}</p>
        <p><strong>Jabatan:</strong> {{ $tenagaPendidik->jabatan }}</p>
        <p><strong>Status Kepegawaian:</strong> {{ $tenagaPendidik->status_kepegawaian }}</p>
        <p><strong>Pendidikan Terakhir:</strong> {{ $tenagaPendidik->pendidikan_terakhir }}</p>
        <p><strong>Jenis Kelamin:</strong> {{ $tenagaPendidik->jenis_kelamin }}</p>
        <p><strong>No HP:</strong> {{ $tenagaPendidik->no_hp }}</p>
        <p><strong>Email:</strong> {{ $tenagaPendidik->email }}</p>
        <p><strong>Alamat:</strong> {{ $tenagaPendidik->alamat }}</p>
        <p><strong>Keterangan:</strong> {{ $tenagaPendidik->keterangan }}</p>
        <p><strong>File:</strong>
            @if($tenagaPendidik->file_url)
                <a href="{{ $tenagaPendidik->file_url }}" target="_blank" class="text-blue-500 underline">Lihat / Download</a>
            @else
                -
            @endif
        </p>
    </div>

    <a href="{{ route('tenaga-pendidik.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
</div>
</x-app-layout>
