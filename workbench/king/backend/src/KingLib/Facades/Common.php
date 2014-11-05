<?php namespace King\Backend;

use Illuminate\Support\Facades\Facade;

class _Common extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'common'; }

}