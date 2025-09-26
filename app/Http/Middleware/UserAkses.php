<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$type): Response
    {

        if (Auth::check()) {

            if (in_array(Auth::user()->type, $type)) {
                
                return $next($request);
            }

            $user = Auth::user(); 
            // Cek tipe pengguna dan redirect sesuai tipe
            if ($user->type === 'admin' || $user->type === 'manager') {
                return redirect()->route('admin.dashboard'); // Redirect untuk admin
            } elseif ($user->type === 'user') {
                return redirect()->route('home.pegawai'); // Redirect untuk user biasa
            }
            
           
            
            
            // abort(403);
            // return redirect()->route('login');
            // if (Auth::user()->type === $type) {
        }
        
        // return $next($request);
        // Jika tidak, redirect atau tampilkan error
        // abort(401);
        return $next($request);
    }
}
