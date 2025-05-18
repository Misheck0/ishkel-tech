<?php

namespace App\Providers;

use App\Models\Invoices;
use App\Observers\InvoiceObserver;
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
    public function boot()
    {
        Invoices::observe(InvoiceObserver::class);
        
    }
}
