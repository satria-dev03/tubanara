<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paksa semua tautan dan aset (CSS/JS) memakai HTTPS
        URL::forceScheme('https');

        // Otomatis sesuaikan URL aset dengan domain Cloudflare yang sedang aktif
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            URL::forceRootUrl("https://" . $_SERVER['HTTP_X_FORWARDED_HOST']);
        }
    }
}