<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AccessRequestController extends Controller
{
    public function requestAccess($menu)
    {
        $menuNames = [
            'tenaga-pendidik' => 'Tenaga Pendidik',
            'dosen' => 'Dosen', 
            'ruangan' => 'Ruangan',
            'arsip' => 'Arsip'
        ];

        return view('access-request', [
            'menu' => $menu,
            'menuName' => $menuNames[$menu] ?? $menu
        ]);
    }

    public function submitRequest(Request $request)
    {
        $request->validate([
            'menu' => 'required|string',
            'reason' => 'required|string|min:10'
        ]);

        // Di sini Anda bisa:
        // 1. Simpan ke table access_requests
        // 2. Kirim notifikasi ke superadmin
        // 3. Kirim email, dll.

        return redirect()->route('dashboard')
            ->with('success', 'Permintaan akses telah dikirim ke superadmin. Anda akan mendapat notifikasi ketika disetujui.');
    }
}