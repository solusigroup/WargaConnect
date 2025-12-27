<?php

namespace App\Providers;

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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure Midtrans
        // Support both config/midtrans.php and config/services.php
        \Midtrans\Config::$serverKey = config('midtrans.server_key') ?? config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production') ?? config('services.midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized') ?? config('services.midtrans.is_sanitized', true);
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds') ?? config('services.midtrans.is_3ds', true);
    }
}
