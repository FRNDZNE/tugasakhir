<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class GrantedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $status): Response
    {
        $user = Auth::user();
        if ($user->mahasiswa->status == $status) {
            return $next($request);
        }

        return abort('403','Akun Anda Belum Diaktifkan, Silahkan Hubungi Staf Prodi');
    }
}
