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
        $this->app->singleton('baseUrlNameCheap', function () {
            return '/home/metiszec/arnews.metiraq.com/'; // Replace "abc" with your desired value or logic to fetch the data.
        });
    }
}
