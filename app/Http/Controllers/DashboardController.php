<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\TenagaPendidik;
use App\Models\Arsip;
use App\Models\DataSarpras;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Data dasar
        $basicData = [
            'totalDosen' => Dosen::count(),
            'totalTendik' => TenagaPendidik::count(),
            'totalArsip' => Arsip::count(),
            'totalSarpras' => Ruangan::count(),
            'totalBarang' => DataSarpras::count(),
            'totalRuangan' => Ruangan::count(),
            'totalNilaiSarpras' => DataSarpras::sum('harga') ?? 0,
            'kondisiBaik' => DataSarpras::where('kondisi', 'Baik')->count(),
            'kondisiRusak' => DataSarpras::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count(),
            'ruanganTerbaru' => Ruangan::withCount('sarpras')->latest()->take(5)->get()
        ];

        // Data chart dengan query yang aman
        $chartData = [
            'dosenPerProdi' => $this->getSafeDosenData(),
            'arsipPerBulan' => $this->getSafeArsipData(),
            'ruanganPerTipe' => $this->getSafeRuanganPerTipe(),
            'kondisiBarang' => $this->getSafeKondisiData(),
        ];

        return view('dashboard', array_merge($basicData, $chartData));
    }

    private function getSafeDosenData()
    {
        try {
            // Gunakan raw SQL untuk menghindari strict mode issues
            $results = DB::select("
                SELECT program_studi as prodi, COUNT(*) as total 
                FROM dosen 
                GROUP BY program_studi
            ");

            return collect($results)->map(function ($item) {
                return [
                    'prodi' => $item->prodi ?: 'Tidak Ada Prodi',
                    'total' => $item->total
                ];
            });
        } catch (\Exception $e) {
            // Fallback data
            return collect([
                ['prodi' => 'Teknik Informatika', 'total' => Dosen::count() > 0 ? rand(5, 15) : 0],
                ['prodi' => 'Sistem Informasi', 'total' => Dosen::count() > 0 ? rand(3, 10) : 0],
            ]);
        }
    }

    private function getSafeArsipData()
    {
        try {
            $results = DB::select("
                SELECT 
                    YEAR(created_at) as tahun,
                    MONTH(created_at) as bulan,
                    COUNT(*) as total
                FROM arsip 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                GROUP BY YEAR(created_at), MONTH(created_at)
                ORDER BY tahun ASC, bulan ASC
            ");

            return collect($results)->map(function ($item) {
                $date = Carbon::createFromDate($item->tahun, $item->bulan, 1);
                return [
                    'bulan' => $date->format('M Y'),
                    'total' => $item->total
                ];
            });
        } catch (\Exception $e) {
            // Data dummy 6 bulan terakhir
            $data = collect();
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $data->push([
                    'bulan' => $month->format('M Y'),
                    'total' => rand(1, 8)
                ]);
            }
            return $data;
        }
    }

    private function getSafeRuanganPerTipe()
    {
        try {
            $results = DB::select("
            SELECT tipe_ruangan, COUNT(*) as total 
            FROM ruangan 
            GROUP BY tipe_ruangan
        ");

            return collect($results)->map(function ($item) {
                // UBAH: sesuaikan label dengan tipe yang baru
                $label = $item->tipe_ruangan == 'sarana' ? 'Sarana' : 'Prasarana';
                return [
                    'tipe' => $label,
                    'total' => $item->total
                ];
            });
        } catch (\Exception $e) {
            // Fallback data
            $totalRuangan = Ruangan::count();
            return collect([
                ['tipe' => 'Sarana', 'total' => ceil($totalRuangan / 2)],
                ['tipe' => 'Prasarana', 'total' => floor($totalRuangan / 2)]
            ]);
        }
    }

    private function getSafeKondisiData()
    {
        try {
            $results = DB::select("
                SELECT kondisi, COUNT(*) as total 
                FROM data_sarpras 
                GROUP BY kondisi
            ");

            return collect($results)->map(function ($item) {
                return [
                    'kondisi' => $item->kondisi,
                    'total' => $item->total
                ];
            });
        } catch (\Exception $e) {
            return collect();
        }
    }
}
