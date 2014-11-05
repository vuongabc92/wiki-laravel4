<?php

namespace King\Backend\Common;

use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register 'underlyingclass' instance container to our UnderlyingClass object
        $this->app['common'] = $this->app->share(function($app)
        {
            return new Common;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Common', 'King\Backend\_Common');
        });
    }
}