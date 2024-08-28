<?php

namespace App\Providers;

use App\Models\ServicioOperacion;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\DictamenOp;
use App\Models\ServicioAnexo;
use Illuminate\Support\Facades\Auth;

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


    }
}
