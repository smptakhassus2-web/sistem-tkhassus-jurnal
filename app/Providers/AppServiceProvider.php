<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon; // 🔴 BARIS BARU: Memanggil library Carbon

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
        // 🔴 BARIS BARU: Memaksa Carbon menggunakan bahasa Indonesia untuk format tanggal
        Carbon::setLocale('id');
    }
}