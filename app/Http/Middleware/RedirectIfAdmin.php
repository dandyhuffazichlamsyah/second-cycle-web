<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     * Redirect admin users to admin dashboard when trying to access customer pages
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->hasAdminAccess()) {
            // If admin tries to access customer-only pages, redirect to admin dashboard
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
