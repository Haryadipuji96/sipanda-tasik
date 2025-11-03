<?php

namespace App\Http\Middleware;

use App\Models\UserLogin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Update last_activity untuk session yang masih aktif
            UserLogin::where('id_user', Auth::id())
                ->whereNull('logged_out_at')
                ->latest('logged_in_at')
                ->first()
                ?->update(['last_activity' => now()]);
        }

        return $next($request);
    }
}