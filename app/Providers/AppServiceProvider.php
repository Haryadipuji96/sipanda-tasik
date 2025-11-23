<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom Blade directive @canSuperadmin
        Blade::if('canSuperadmin', function () {
            return Auth::check() && Auth::user()->role === 'superadmin';
        });

        // Custom Blade directive @canAccess - untuk permission based access
        Blade::if('canAccess', function ($menuKey) {
            if (!Auth::check()) return false;
            
            $user = Auth::user();
            return $user->hasPermission($menuKey);
        });

        // Custom Blade directive @canCrud - untuk permission based CRUD
        Blade::if('canCrud', function ($menuKey) {
            if (!Auth::check()) return false;
            
            $user = Auth::user();
            return $user->canCrud($menuKey);
        });

        // Custom Blade directive untuk role user biasa (hanya view)
        Blade::if('isRegularUser', function () {
            return Auth::check() && Auth::user()->role === 'user';
        });
    }
}