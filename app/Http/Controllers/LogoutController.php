<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Cari record login terakhir yang belum logout
            $lastLogin = UserLogin::where('id_user', $user->id)
                ->whereNull('logged_out_at')
                ->latest('logged_in_at')
                ->first();

            if ($lastLogin) {
                $lastLogin->update([
                    'logged_out_at' => now()
                ]);
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}