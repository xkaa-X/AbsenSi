<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== $role) {
            // Jika siswa mencoba masuk ke guru area, alihkan ke siswa dashboard
            if (auth()->user()->role === 'siswa') {
                return redirect()->route('siswa.dashboard')->with('error', 'Aksi ini hanya diizinkan untuk Guru!');
            }
            
            // Jika guru mencoba masuk ke siswa area, alihkan ke guru dashboard
            if (auth()->user()->role === 'guru') {
                return redirect()->route('dashboard');
            }

            abort(403, 'Aksi tidak diizinkan.');
        }

        return $next($request);
    }
}
