<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;



class ProfileController extends Controller
{
    /**
     * Tampilkan form profil pengguna.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update informasi profil (nama, email, dsb).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        $user->fill($data);

        // Reset verifikasi email jika email berubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update hanya foto profil (disimpan ke public/profile_photos).
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        /** @var \App\Models\User $user */
       $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->profile_photo && file_exists(public_path('profile_photos/' . $user->profile_photo))) {
            unlink(public_path('profile_photos/' . $user->profile_photo));
        }

        // Upload ke folder public/profile_photos
        $file = $request->file('profile_photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('profile_photos'), $filename);

        // Simpan nama file ke database
        $user->profile_photo = $filename;
        $user->save();

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }


    /**
     * Hapus akun pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
