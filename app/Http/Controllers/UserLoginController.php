<?php

namespace App\Http\Controllers;

use App\Models\UserLogin;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserLoginController extends Controller
{
    public function index()
    {
        $search = request()->input('search');

        // Hitung ranking berdasarkan total durasi (Exclude superadmin)
        $rankingsQuery = User::select('users.id', 'users.name', 'users.email', 'users.role')
            ->leftJoin('userlogin', 'users.id', '=', 'userlogin.id_user')
            ->selectRaw('COUNT(userlogin.id) as total_login')
            ->selectRaw('SUM(
                CASE 
                    WHEN userlogin.logged_out_at IS NOT NULL 
                    THEN TIMESTAMPDIFF(SECOND, userlogin.logged_in_at, userlogin.logged_out_at)
                    WHEN userlogin.last_activity IS NOT NULL
                    THEN TIMESTAMPDIFF(SECOND, userlogin.logged_in_at, userlogin.last_activity)
                    ELSE 0
                END
            ) as total_duration_seconds')
            ->selectRaw('MAX(CASE WHEN userlogin.logged_out_at IS NULL THEN 1 ELSE 0 END) as is_online')
            ->where('users.role', '!=', 'superadmin'); // Exclude superadmin

        if ($search) {
            $rankingsQuery->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%");
            });
        }

        $rankings = $rankingsQuery->groupBy('users.id', 'users.name', 'users.email', 'users.role')
            ->orderByDesc('total_duration_seconds')
            ->get()
            ->map(function ($user, $index) {
                $seconds = $user->total_duration_seconds ?? 0;
                $hours = floor($seconds / 3600);
                $minutes = floor(($seconds % 3600) / 60);
                $secs = $seconds % 60;

                $user->rank = $index + 1;
                $user->formatted_duration = sprintf('%d jam %d menit %d detik', $hours, $minutes, $secs);
                $user->total_hours = round($seconds / 3600, 2);
                $user->status = $user->is_online ? 'online' : 'offline';

                return $user;
            });

        return view('page.userlogin.index', compact('rankings'));
    }

    // Method untuk menampilkan detail history per user
    public function detail($userId)
    {
        $user = User::findOrFail($userId);
        
        // Pastikan bukan superadmin
        if ($user->role === 'superadmin') {
            abort(404);
        }

        // Ambil history login user dengan pagination
        $histories = UserLogin::where('id_user', $userId)
            ->orderBy('logged_in_at', 'desc')
            ->paginate(20);

        // Hitung total statistik
        $totalStats = UserLogin::where('id_user', $userId)
            ->selectRaw('COUNT(*) as total_login')
            ->selectRaw('SUM(
                CASE 
                    WHEN logged_out_at IS NOT NULL 
                    THEN TIMESTAMPDIFF(SECOND, logged_in_at, logged_out_at)
                    WHEN last_activity IS NOT NULL
                    THEN TIMESTAMPDIFF(SECOND, logged_in_at, last_activity)
                    ELSE 0
                END
            ) as total_duration_seconds')
            ->first();

        $seconds = $totalStats->total_duration_seconds ?? 0;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        $stats = [
            'total_login' => $totalStats->total_login ?? 0,
            'total_hours' => round($seconds / 3600, 2),
            'formatted_duration' => sprintf('%d jam %d menit', $hours, $minutes)
        ];

        return view('page.userlogin.detail', compact('user', 'histories', 'stats'));
    }
}