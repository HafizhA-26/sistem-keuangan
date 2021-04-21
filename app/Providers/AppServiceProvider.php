<?php

namespace App\Providers;

use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        $charts->register([
            \App\Charts\BosChart::class,
            \App\Charts\AllTransactionChart::class,
        ]);
        Paginator::defaultView('vendor.pagination.bootstrap-4');

        Paginator::defaultSimpleView('vendor.pagination.simple-bootstrap-4');
        
    }
}
