<?php

namespace App\Http\Controllers;

use App\Models\UserLogin;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserLoginController extends Controller
{
    public function index()
    {
        $search = request()->input('search'); // Ambil input search

        // Ambil history login dengan pagination
        $logins = UserLogin::with(['user' => function ($query) use ($search) {
            $query->select('id', 'name', 'email', 'role');
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }
        }])
            ->whereHas('user', function ($query) use ($search) {
                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                }
            })
            ->orderBy('logged_in_at', 'desc')
            ->paginate(10);

        // Hitung ranking berdasarkan total durasi
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
            ->where('users.role', '!=', 'superadmin'); // Exclude superadmin dari ranking

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

                return $user;
            });

        return view('page.userlogin.index', compact('logins', 'rankings'));
    }
}
