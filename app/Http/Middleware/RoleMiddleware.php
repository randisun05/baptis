<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Daftar semua guard yang mungkin digunakan di aplikasi Anda.
     * Guard ini akan diperiksa secara berurutan.
     */
    protected $guards = ['web', 'member'];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles  Role yang disyaratkan, dipisahkan koma dari route.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $authenticatedUser = null;
        $userRole = null;

        // 1. Iterasi semua guard untuk menemukan pengguna yang sedang login
        foreach ($this->guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Pengguna ditemukan di guard ini
                $authenticatedUser = Auth::guard($guard)->user();

                // Ambil role pengguna dari model yang sedang aktif
                // ASUMSI: Semua model yang terhubung ke guard ini memiliki kolom 'role'
                $userRole = $authenticatedUser->role;
                break; // Hentikan iterasi
            }
        }
        // 2. Jika tidak ada pengguna yang terotentikasi di guard manapun
        if (!$authenticatedUser) {
            return redirect('login');
        }

        // 3. Cek Otorisasi Role
        // Pastikan role pengguna ($userRole) ada dalam daftar role yang disyaratkan ($roles)
        if (!in_array($userRole, $roles)) {
            // Tolak akses jika role tidak sesuai
            abort(403, 'Akses Ditolak: Peran (' . $userRole . ') Anda tidak diizinkan untuk mengakses halaman ini.');
        }

        // 4. Lanjutkan permintaan
        return $next($request);
    }
}
