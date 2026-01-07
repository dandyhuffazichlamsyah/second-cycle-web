<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CeoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Check if user has CEO access
        if (!auth()->user()->hasCeoAccess()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akses ditolak. Hanya CEO yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
