<x-app-layout>
    <x-slot name="title">Beranda</x-slot>
    <div class="p-6 bg-gray-50 min-h-screen">

        <!-- Header Interaktif -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div>
                <h1 id="greeting" class="text-3xl font-extrabold text-blue-900 flex items-center gap-4">
                    Selamat Datang, {{ Auth::user()->name }}
                    <span id="digitalClock" class="ml-4 text-lg font-mono text-gray-500"></span>
                </h1>
                <p id="dailyQuote" class="text-gray-500 mt-1 text-lg">Ringkasan data terbaru di Bank Data Arsip Kampus</p>
                <p id="currentDateTime" class="text-gray-400 mt-1 text-sm"></p>
            </div>
        </div>

        <!-- Cards Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div
                class="bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-xl shadow-lg p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
                <div>
                    <h2 class="text-lg font-semibold">Total Dosen</h2>
                    <p class="text-3xl font-bold mt-2">{{ $totalDosen }}</p>
                </div>
                <i class="fas fa-chalkboard-teacher fa-3x opacity-80"></i>
            </div>

            <div
                class="bg-gradient-to-r from-pink-500 to-orange-400 text-white rounded-xl shadow-lg p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
                <div>
                    <h2 class="text-lg font-semibold">Total Tenaga Pendidik</h2>
                    <p class="text-3xl font-bold mt-2">{{ $totalTendik }}</p>
                </div>
                <i class="fas fa-user-tie fa-3x opacity-80"></i>
            </div>

            <div
                class="bg-gradient-to-r from-orange-400 to-amber-300 text-white rounded-xl shadow-lg p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
                <div>
                    <h2 class="text-lg font-semibold">Total Dokumen Arsip</h2>
                    <p class="text-3xl font-bold mt-2">{{ $totalArsip }}</p>
                </div>
                <i class="fas fa-file-alt fa-3x opacity-80"></i>
            </div>

            <div
                class="bg-gradient-to-r from-indigo-500 to-purple-400 text-white rounded-xl shadow-lg p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
                <div>
                    <h2 class="text-lg font-semibold">Total Sarpras</h2>
                    <p class="text-3xl font-bold mt-2">{{ $totalSarpras }}</p>
                </div>
                <i class="fas fa-boxes fa-3x opacity-80"></i>
            </div>
        </div>

        <!-- Grafik -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Dosen per Prodi</h2>
                <canvas id="chartDosenPerProdi" class="rounded-lg shadow-inner p-2 bg-gray-50"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Dokumen per Bulan</h2>
                <canvas id="chartArsipPerBulan" class="rounded-lg shadow-inner p-2 bg-gray-50"></canvas>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // ------------------ Greeting Dinamis ------------------
            const greetingEl = document.getElementById('greeting');
            const now = new Date();
            const hour = now.getHours();
            let greeting = "Selamat Datang";

            if (hour >= 4 && hour < 12) greeting = "Selamat Pagi";
            else if (hour >= 12 && hour < 15) greeting = "Selamat Siang";
            else if (hour >= 15 && hour < 18) greeting = "Selamat Sore";
            else greeting = "Selamat Malam";

            greetingEl.childNodes[0].textContent = `${greeting}, {{ Auth::user()->name }} 👋`;

            // ------------------ Quote Harian ------------------
            const quotes = [
                "“Pendidikan adalah senjata paling ampuh untuk mengubah dunia.” – Nelson Mandela",
                "“Belajar tanpa berpikir itu sia-sia, berpikir tanpa belajar itu berbahaya.” – Confucius",
                "“Kesuksesan adalah hasil dari persiapan, kerja keras, dan belajar dari kegagalan.” – Colin Powell",
                "“Ilmu pengetahuan adalah harta yang paling berharga.” – Mahatma Gandhi",
                "“Orang yang berhenti belajar akan menjadi tua, baik umur 20 atau 80.” – Henry Ford",
                "“Kampus bukan hanya tempat belajar, tapi tempat menginspirasi perubahan.”",
                "“Setiap hari adalah kesempatan baru untuk belajar sesuatu yang baru.”",
                "“Pendidikan membuka pikiran, memperluas pandangan, dan membentuk masa depan.”",
                "“Tidak ada kata terlambat untuk belajar dan memperbaiki diri.”",
                "“Guru membuka pintu, tapi kamu harus masuk sendiri.” – Pepatah Tiongkok",
                "“Masa depan milik mereka yang mempersiapkan diri hari ini.” – Malcolm X",
                "“Kegagalan adalah bagian dari proses menuju keberhasilan.”",
                "“Belajarlah seolah-olah kamu akan hidup selamanya.” – Mahatma Gandhi",
                "“Tujuan pendidikan adalah menggantikan pikiran kosong dengan pikiran terbuka.” – Malcolm Forbes",
                "“Ilmu tanpa amal bagaikan pohon tanpa buah.” – Ali bin Abi Thalib",
                "“Pendidikan bukan persiapan untuk hidup, pendidikan adalah kehidupan itu sendiri.” – John Dewey",
                "“Satu jam belajar akan mengubah hari, satu hari belajar akan mengubah hidup.”",
                "“Kampus adalah tempat menanam mimpi, bukan sekadar mencari nilai.”",
                "“Belajar adalah investasi terbaik yang hasilnya tidak akan pernah hilang.”",
                "“Orang berilmu tidak hanya pintar, tapi juga bijak dalam bertindak.”",
                "“Motivasi datang dari dalam diri, bukan dari nilai di kertas.”",
                "“Pendidikan adalah perjalanan tanpa akhir.”",
                "“Setiap buku yang kamu baca membuka satu jendela baru di pikiranmu.”",
                "“Keberhasilan akademik bukanlah akhir, tapi awal dari kontribusi nyata.”",
                "“Jangan takut salah, karena dari kesalahanlah kita belajar menjadi benar.”",
                "“Berpikir kritis adalah kunci dari kemajuan peradaban.”",
                "“Mahasiswa sejati bukan hanya mengejar gelar, tapi juga kebenaran dan perubahan.”",
                "“Pendidikan sejati adalah yang membebaskan, bukan yang membatasi.” – Ki Hajar Dewantara",
                "“Dengan ilmu, kita terangkat. Dengan adab, kita dimuliakan.”",
                "“Semakin banyak kamu tahu, semakin kamu sadar betapa banyak yang belum kamu ketahui.” – Aristoteles"
            ];
            const today = new Date();
            const dayIndex = today.getDate() % quotes.length;
            document.getElementById('dailyQuote').innerText = quotes[dayIndex];

            // ------------------ Tanggal & Jam Realtime ------------------
            function updateDateTime() {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const dateString = now.toLocaleDateString('id-ID', options);
                const timeString = now.toLocaleTimeString('id-ID');
                document.getElementById('currentDateTime').innerText = `${dateString} | ${timeString}`;

                // Digital clock di samping greeting
                // document.getElementById('digitalClock').innerText = timeString;
            }
            updateDateTime();
            setInterval(updateDateTime, 1000);

            // ------------------ Chart Dosen Per Prodi ------------------
            const dosenPerProdi = @json($dosenPerProdi);
            const arsipPerBulan = @json($arsipPerBulan);

            const dosenLabels = dosenPerProdi.map(d => d.prodi);
            const dosenData = dosenPerProdi.map(d => d.total);

            new Chart(document.getElementById('chartDosenPerProdi'), {
                type: 'bar',
                data: {
                    labels: dosenLabels,
                    datasets: [{
                        label: 'Jumlah Dosen',
                        data: dosenData,
                        backgroundColor: [
                            'rgba(236, 72, 153, 0.7)', // pink
                            'rgba(168, 85, 247, 0.7)', // purple
                            'rgba(251, 146, 60, 0.7)', // orange
                            'rgba(59, 130, 246, 0.7)', // blue
                            'rgba(34, 197, 94, 0.7)' // green
                        ]
                    }]
                },
                options: {
                    responsive: true
                }
            });
            // ------------------ Chart Arsip Per Bulan ------------------
            const arsipLabels = arsipPerBulan.map(a => 'Bulan ' + a.bulan);
            const arsipData = arsipPerBulan.map(a => a.total);

            new Chart(document.getElementById('chartArsipPerBulan'), {
                type: 'line',
                data: {
                    labels: arsipLabels,
                    datasets: [{
                        label: 'Jumlah Dokumen',
                        data: arsipData,
                        borderColor: 'rgba(236, 72, 153, 0.9)',
                        backgroundColor: 'rgba(236, 72, 153, 0.15)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(236, 72, 153, 0.9)',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true
                }
            });
        </script>
    @endpush
</x-app-layout>
