<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Fix for Vercel Read-Only Filesystem
        if (env('VERCEL') || request()->server('VERCEL') || isset($_SERVER['VERCEL'])) {
            config(['view.compiled' => '/tmp']);
        }
    }
}
