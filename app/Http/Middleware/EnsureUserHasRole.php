<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request to verify user role authorization.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Cek Autentikasi
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan masuk (login) terlebih dahulu untuk mengakses menu ini.');
        }

        $user = Auth::user();

        // 2. Cek Status Akun
        if (strcasecmp($user->status, 'Aktif') !== 0) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda sedang dinonaktifkan oleh Administrator.',
            ]);
        }

        // 3. Cek Kesesuaian Role
        $matched = empty($roles);
        foreach ($roles as $role) {
            if (strcasecmp($user->role, $role) === 0) {
                $matched = true;
                break;
            }
        }

        if (!$matched) {
            // Jika user adalah Nasabah yang mencoba mengakses panel manajemen admin/operasional
            if (strcasecmp($user->role, 'Nasabah') === 0) {
                return response()->view('errors.403', [
                    'message' => 'Halaman ini merupakan area manajemen operasional. Sebagai Nasabah, Anda hanya memiliki izin untuk mengakses Papan Informasi Publik EcoBank.',
                    'userRole' => $user->role,
                    'requiredRoles' => implode(', ', $roles),
                ], 403);
            }

            // Jika role lain (misal Petugas mengakses menu khusus Admin)
            return response()->view('errors.403', [
                'message' => 'Fitur ini hanya dapat dikelola oleh Administrator EcoBank.',
                'userRole' => $user->role,
                'requiredRoles' => implode(', ', $roles),
            ], 403);
        }

        return $next($request);
    }
}
