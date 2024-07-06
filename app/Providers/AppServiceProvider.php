<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\ExcelServiceProvider;

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

        if (auth()->check()) {
            Config::set('app.timezone', auth()->user()->timezone);
        }

        $locale = session('locale', 'ar'); // Default to English if no locale is set in the session
        App::setLocale($locale);

        if (class_exists(ExcelServiceProvider::class)) {
            $this->app->register(ExcelServiceProvider::class);
        }

    }
}
