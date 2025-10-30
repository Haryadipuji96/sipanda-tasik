<?php

namespace App\Http\Controllers;

use App\Models\UserLogin;
use Illuminate\Http\Request;

class UserLoginController extends Controller
{
    public function index()
    {
        // Ambil data dengan pagination dan filter yang lebih baik
        $logins = UserLogin::with(['user' => function($query) {
                $query->select('id', 'name', 'email', 'role');
            }])
            ->whereHas('user', function($query) {
                $query->where('role', '!=', 'admin');
            })
            ->orderBy('logged_in_at', 'desc')
            ->paginate(10); // atau ->get() jika tanpa pagination

        return view('page.userlogin.index', compact('logins'));
    }
}