<?php

namespace King\Backend;

use Illuminate\Support\ServiceProvider;

class StatusServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register 'underlyingclass' instance container to our UnderlyingClass object
        $this->app['status'] = $this->app->share(function($app)
        {
            return new Status;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Status', 'King\Backend\Facades\Status');
        });
    }
}