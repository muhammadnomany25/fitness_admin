<?php

namespace App\Providers;

use App\Models\Notification;
use App\Observers\NotificationObserver;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
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
        Notification::observe(NotificationObserver::class);

        if (auth()->check()) {
            Config::set('app.timezone', auth()->user()->timezone);
        }

        $locale = session('locale', 'en'); // Default to English if no locale is set in the session
        App::setLocale($locale);

        if (class_exists(ExcelServiceProvider::class)) {
            $this->app->register(ExcelServiceProvider::class);
        }

        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label(trans('general.users_group'))
                    ->icon('heroicon-o-user')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('Diet')
                    ->icon('heroicon-s-shopping-cart'),
                NavigationGroup::make()
                    ->label('Workouts')
                    ->icon('heroicon-o-currency-dollar'),
            ]);
        });

    }
}
