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
        // Helpers globales del contenido editable de la landing: cms() y cms_img().
        // Se cargan aquí para no depender de composer dump-autoload en producción.
        require_once app_path('Support/cms_helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
