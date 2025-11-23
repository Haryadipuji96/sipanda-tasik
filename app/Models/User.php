<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'last_login_at',
        'role',
        'menu_key'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function logins(): HasMany
    {
        return $this->hasMany(UserLogin::class, 'id_user', 'id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

    // ==================== METHOD PERMISSION YANG DIPERBAIKI ====================

    /**
     * Method untuk mengecek apakah user bisa MELIHAT menu
     * - Superadmin: bisa lihat semua
     * - User: bisa lihat semua menu data (view-only)
     * - Admin: cek permission yang diberikan
     */
    public function hasPermission($menuKey): bool
    {
        // 1. Superadmin memiliki semua permission
        if ($this->role === 'superadmin') {
            return true;
        }

        // 2. User biasa bisa melihat semua data (view-only)
        if ($this->role === 'user') {
            $viewableMenus = [
                'dashboard', 'profile',
                'arsip', 'ruangan', 'tenaga-pendidik', 'dosen'
            ];
            return in_array($menuKey, $viewableMenus);
        }

        // 3. Admin cek permission yang diberikan
        return $this->permissions->contains('menu_key', $menuKey);
    }

    /**
     * Method untuk mengecek apakah user bisa CRUD (Create, Read, Update, Delete)
     * - Superadmin: bisa CRUD semua
     * - User: TIDAK bisa CRUD (hanya view)
     * - Admin: bisa CRUD hanya untuk menu yang diberikan permission
     */
    public function canCrud($menuKey): bool
    {
        // 1. Superadmin bisa CRUD semua
        if ($this->role === 'superadmin') {
            return true;
        }

        // 2. User tidak bisa CRUD (hanya view saja)
        if ($this->role === 'user') {
            return false;
        }

        // 3. Admin bisa CRUD hanya untuk menu yang diberikan permission
        return $this->hasPermission($menuKey);
    }

    // ==================== METHOD HELPER ====================

    public function getAllowedMenus(): array
    {
        if ($this->role === 'superadmin') {
            return ['all'];
        }

        if ($this->role === 'user') {
            return ['dashboard', 'profile','dokumen-mahasiswa', 'arsip', 'ruangan', 'tenaga-pendidik', 'dosen'];
        }

        return $this->permissions->pluck('menu_key')->toArray();
    }

    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isRegularUser(): bool
    {
        return $this->role === 'user';
    }
}