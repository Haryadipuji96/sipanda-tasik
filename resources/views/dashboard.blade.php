<x-app-layout>
    <x-slot name="title">Beranda</x-slot>

    <style>
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 250px;
            }
        }

        @media (max-width: 640px) {
            .chart-container {
                height: 200px;
            }
        }
    </style>

    <div class="p-4 sm:p-6 bg-gray-50 min-h-screen">
        <!-- Header Interaktif -->
        <div class="mb-6 sm:mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div class="flex-1">
                <h1 id="greeting"
                    class="text-2xl sm:text-3xl font-extrabold text-blue-900 flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <span>Selamat Datang, {{ Auth::user()->name }}</span>
                    <span id="digitalClock" class="text-base sm:text-lg font-mono text-gray-500"></span>
                </h1>
                <p id="dailyQuote" class="text-gray-500 mt-1 text-sm sm:text-lg">Ringkasan data terbaru di Bank Data Arsip
                    Kampus</p>
                <p id="currentDateTime" class="text-gray-400 mt-1 text-xs sm:text-sm"></p>
            </div>
        </div>

        <!-- Cards Ringkasan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div
                class="bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-xl shadow-lg p-4 sm:p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
                <div>
                    <h2 class="text-sm sm:text-lg font-semibold">Total Dosen</h2>
                    <p class="text-2xl sm:text-3xl font-bold mt-1 sm:mt-2">{{ $totalDosen }}</p>
                </div>
                <i class="fas fa-chalkboard-teacher text-2xl sm:text-3xl opacity-80"></i>
            </div>

            <div
                class="bg-gradient-to-r from-pink-500 to-orange-400 text-white rounded-xl shadow-lg p-4 sm:p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
                <div>
                    <h2 class="text-sm sm:text-lg font-semibold">Total Tenaga Pendidik</h2>
                    <p class="text-2xl sm:text-3xl font-bold mt-1 sm:mt-2">{{ $totalTendik }}</p>
                </div>
                <i class="fas fa-user-tie text-2xl sm:text-3xl opacity-80"></i>
            </div>

            <div
                class="bg-gradient-to-r from-orange-400 to-amber-300 text-white rounded-xl shadow-lg p-4 sm:p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
                <div>
                    <h2 class="text-sm sm:text-lg font-semibold">Total Dokumen Arsip</h2>
                    <p class="text-2xl sm:text-3xl font-bold mt-1 sm:mt-2">{{ $totalArsip }}</p>
                </div>
                <i class="fas fa-file-alt text-2xl sm:text-3xl opacity-80"></i>
            </div>

            <div
                class="bg-gradient-to-r from-indigo-500 to-purple-400 text-white rounded-xl shadow-lg p-4 sm:p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
                <div>
                    <h2 class="text-sm sm:text-lg font-semibold">Total Sarpras</h2>
                    <p class="text-2xl sm:text-3xl font-bold mt-1 sm:mt-2">{{ $totalSarpras }}</p>
                    <p class="text-xs sm:text-sm opacity-90 mt-1">{{ $totalBarang }} barang</p>
                </div>
                <i class="fas fa-boxes text-2xl sm:text-3xl opacity-80"></i>
            </div>
        </div>

        <!-- Stats Sarpras Detail -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
            <div class="bg-white rounded-lg shadow-sm border p-3 sm:p-4 text-center">
                <div class="text-xl sm:text-2xl font-bold text-blue-600">{{ $totalRuangan }}</div>
                <div class="text-xs sm:text-sm text-gray-600">Total Ruangan</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border p-3 sm:p-4 text-center">
                <div class="text-xl sm:text-2xl font-bold text-green-600">Rp
                    {{ number_format($totalNilaiSarpras, 0, ',', '.') }}</div>
                <div class="text-xs sm:text-sm text-gray-600">Total Nilai Sarpras</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border p-3 sm:p-4 text-center">
                <div class="text-xl sm:text-2xl font-bold text-purple-600">{{ $kondisiBaik }}</div>
                <div class="text-xs sm:text-sm text-gray-600">Barang Kondisi Baik</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border p-3 sm:p-4 text-center">
                <div class="text-xl sm:text-2xl font-bold text-orange-600">{{ $kondisiRusak }}</div>
                <div class="text-xs sm:text-sm text-gray-600">Barang Perlu Perbaikan</div>
            </div>
        </div>

        <!-- Grafik -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Tenaga Pendidik per Status Kepegawaian</h2>
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="chartTendikStatus" height="300"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Dokumen per Bulan</h2>
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="chartArsipPerBulan" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Sarpras -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Ruangan per Tipe</h2>
                <div class="chart-container">
                    <canvas id="chartRuanganPerTipe"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Kondisi Barang</h2>
                <div class="chart-container">
                    <canvas id="chartKondisiBarang"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabel Ruangan Terbaru -->
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Ruangan Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-xs sm:text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-700">Nama Ruangan</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-700">Tipe</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-700">Lokasi</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-center font-medium text-gray-700">Jumlah Barang
                            </th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-center font-medium text-gray-700">Kondisi</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-center font-medium text-gray-700">Tanggal Dibuat
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($ruanganTerbaru as $ruangan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 sm:px-4 sm:py-3 font-medium text-xs sm:text-sm">
                                    {{ $ruangan->nama_ruangan }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3">
                                    @if ($ruangan->tipe_ruangan == 'sarana')
                                        <span
                                            class="px-2 py-1 text-xs bg-orange-100 text-orange-800 rounded-full">Sarana</span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Prasarana</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3">
                                    @if ($ruangan->tipe_ruangan == 'sarana')
                                        <div class="text-xs sm:text-sm">
                                            <div class="font-medium">{{ $ruangan->prodi->nama_prodi ?? 'N/A' }}</div>
                                            <div class="text-gray-500 text-xs">
                                                {{ $ruangan->prodi->fakultas->nama_fakultas ?? 'N/A' }}</div>
                                        </div>
                                    @else
                                        <div class="text-xs sm:text-sm font-medium text-green-700">
                                            {{ $ruangan->unit_umum }}</div>
                                    @endif
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3 text-center">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                        {{ $ruangan->sarpras_count }} barang
                                    </span>
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3 text-center">
                                    @php
                                        $kondisiColor = match ($ruangan->kondisi_ruangan) {
                                            'Baik' => 'bg-green-100 text-green-800',
                                            'Rusak Ringan' => 'bg-yellow-100 text-yellow-800',
                                            'Rusak Berat' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 text-xs rounded-full {{ $kondisiColor }}">
                                        {{ $ruangan->kondisi_ruangan }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3 text-center text-gray-500 text-xs sm:text-sm">
                                    {{ $ruangan->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 sm:py-8 text-center text-gray-500">
                                    <i class="fas fa-door-open text-2xl sm:text-4xl mb-2 block"></i>
                                    Belum ada data ruangan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($ruanganTerbaru->count() > 0)
                <div class="mt-3 sm:mt-4 text-center">
                    <a href="{{ route('ruangan.index') }}"
                        class="text-blue-600 hover:text-blue-800 text-xs sm:text-sm font-medium">
                        Lihat Semua Ruangan →
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        // Chart.js Library
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Dashboard loaded - initializing charts');

                // =============================================
                // 1. CHART TENAGA PENDIDIK PER STATUS KEPEGAWAIAN
                // =============================================
                const tendikStatusData = @json($tendikStatus ?? []);
                if (tendikStatusData.length > 0) {
                    const labels = tendikStatusData.map(item => item.status);
                    const data = tendikStatusData.map(item => item.total);

                    const ctxTendik = document.getElementById('chartTendikStatus');
                    if (ctxTendik) {
                        new Chart(ctxTendik, {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Jumlah Tenaga Pendidik',
                                    data: data,
                                    backgroundColor: [
                                        'rgba(54, 162, 235, 0.8)', // Blue for TETAP
                                        'rgba(255, 99, 132, 0.8)', // Red for KONTRAK
                                        'rgba(255, 206, 86, 0.8)', // Yellow for others
                                        'rgba(75, 192, 192, 0.8)', // Teal
                                        'rgba(153, 102, 255, 0.8)', // Purple
                                    ],
                                    borderColor: [
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                    ],
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            padding: 20,
                                            font: {
                                                size: window.innerWidth < 640 ? 10 : 12
                                            }
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                let label = context.label || '';
                                                if (label) {
                                                    label += ': ';
                                                }
                                                label += context.raw + ' orang';
                                                return label;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                        console.log('Chart Tendik Status initialized');
                    }
                } else {
                    // Show no data message
                    const container = document.querySelector('#chartTendikStatus').parentElement;
                    container.innerHTML = `
                <div class="flex items-center justify-center h-full text-gray-500">
                    <div class="text-center">
                        <i class="fas fa-chart-pie text-3xl mb-2"></i>
                        <p class="text-sm">Data tenaga pendidik tidak tersedia</p>
                    </div>
                </div>
            `;
                }

                // =============================================
                // 2. CHART ARSIP PER BULAN
                // =============================================
                const arsipData = @json($arsipPerBulan ?? []);
                if (arsipData.length > 0) {
                    const labels = arsipData.map(item => item.bulan);
                    const data = arsipData.map(item => item.total);

                    const ctxArsip = document.getElementById('chartArsipPerBulan');
                    if (ctxArsip) {
                        new Chart(ctxArsip, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Jumlah Dokumen',
                                    data: data,
                                    borderColor: 'rgba(236, 72, 153, 0.9)',
                                    backgroundColor: 'rgba(236, 72, 153, 0.15)',
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: 'rgba(236, 72, 153, 0.9)',
                                    pointBorderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        });
                    }
                } else {
                    // Show no data message
                    const container = document.querySelector('#chartArsipPerBulan').parentElement;
                    container.innerHTML = `
                <div class="flex items-center justify-center h-full text-gray-500">
                    <div class="text-center">
                        <i class="fas fa-chart-line text-3xl mb-2"></i>
                        <p class="text-sm">Data arsip per bulan tidak tersedia</p>
                    </div>
                </div>
            `;
                }

                // =============================================
                // 3. CHART RUANGAN PER TIPE
                // =============================================
                const ruanganData = @json($ruanganPerTipe ?? []);
                if (ruanganData && ruanganData.length > 0) {
                    const labels = ruanganData.map(item => item.tipe);
                    const data = ruanganData.map(item => item.total);

                    const hasData = data.some(total => total > 0);

                    if (hasData) {
                        const ctxRuangan = document.getElementById('chartRuanganPerTipe');
                        if (ctxRuangan) {
                            new Chart(ctxRuangan, {
                                type: 'doughnut',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Jumlah Ruangan',
                                        data: data,
                                        backgroundColor: [
                                            'rgba(251, 146, 60, 0.8)', // Orange untuk Sarana
                                            'rgba(16, 185, 129, 0.8)', // Hijau untuk Prasarana
                                        ],
                                        borderColor: [
                                            'rgba(251, 146, 60, 1)', // Orange untuk Sarana
                                            'rgba(16, 185, 129, 1)', // Hijau untuk Prasarana
                                        ],
                                        borderWidth: 2
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    const label = context.label || '';
                                                    const value = context.raw || 0;
                                                    const total = context.dataset.data.reduce((a, b) => a +
                                                        b, 0);
                                                    const percentage = Math.round((value / total) * 100);
                                                    return `${label}: ${value} ruangan (${percentage}%)`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    }
                }

                // =============================================
                // 4. CHART KONDISI BARANG
                // =============================================
                const kondisiData = @json($kondisiBarang ?? []);
                if (kondisiData.length > 0) {
                    const labels = kondisiData.map(item => item.kondisi);
                    const data = kondisiData.map(item => item.total);

                    const ctxKondisi = document.getElementById('chartKondisiBarang');
                    if (ctxKondisi) {
                        new Chart(ctxKondisi, {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Jumlah Barang',
                                    data: data,
                                    backgroundColor: [
                                        'rgba(16, 185, 129, 0.8)', // Green - Baik
                                        'rgba(245, 158, 11, 0.8)', // Yellow - Rusak Ringan
                                        'rgba(239, 68, 68, 0.8)', // Red - Rusak Berat
                                        'rgba(156, 163, 175, 0.8)' // Gray - Lainnya
                                    ]
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    }
                                }
                            }
                        });
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
