<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Nama bulan/hari berbahasa Indonesia (translatedFormat)
        Carbon::setLocale('id');
    }
}
