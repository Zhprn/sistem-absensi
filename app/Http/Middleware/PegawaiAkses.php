<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PegawaiAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $type): Response
    {
        // Cek apakah pengguna terautentikasi dan memiliki peran admin
        if (Auth::check()) {
            if (Auth::user()->type == 'admin' || Auth::user()->type == 'manager' || Auth::user()->type == 'user') {
                return $next($request);
            }
            abort(403);
        }
        
        // return $next($request);
        // Jika tidak, redirect atau tampilkan error
        abort(401);
    }
}
