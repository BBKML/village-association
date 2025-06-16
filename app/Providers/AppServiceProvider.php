<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\Association;

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


    public function boot()
    {
                // Partage la variable $association avec toutes les vues
        view()->composer('*', function ($view) {
            $view->with('association', Association::first());
        });
        Paginator::useTailwind();
    }
}
