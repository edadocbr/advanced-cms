<?php

namespace Edado\AdvancedCMS\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AdvancedCMSServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //Load routes
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        //Load views
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'advanced_cms');

        //load Translate
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'advanced_cms');

        //load Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        //php artisan vendor:publish --all
        $this->publishes([
            __DIR__ . '/../Resources/views' => resource_path('views/vendor/advanced_cms'),
        ]);

    }

    public function register()
    {
        $this->app->bind(
            \Webkul\CMS\Models\Page::class,
            \Edado\AdvancedCMS\Models\Page::class
        );

        $this->app->bind(
            \Webkul\CMS\Models\PageTranslation::class,
            \Edado\AdvancedCMS\Models\PageTranslation::class
        );

        $this->app->bind(
        \Webkul\Admin\Http\Controllers\CMS\PageController::class, 
        \Edado\AdvancedCMS\Http\Controllers\PageController::class
    );
    }
}