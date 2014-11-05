<?php

namespace King\Backend\Knight;

use Illuminate\Support\ServiceProvider;

class KnightServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register 'underlyingclass' instance container to our UnderlyingClass object
        $this->app['knight'] = $this->app->share(function($app)
        {
            return new Knight;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Common', 'King\Backend\_Knight');
        });
    }
}