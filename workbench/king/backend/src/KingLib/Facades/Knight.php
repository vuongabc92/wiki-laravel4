<?php namespace King\Backend;

use Illuminate\Support\Facades\Facade;

class _Knight extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'knight'; }

}