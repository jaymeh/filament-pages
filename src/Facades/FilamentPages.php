<?php

namespace Jaymeh\FilamentPages\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jaymeh\FilamentPages\FilamentPages
 */
class FilamentPages extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Jaymeh\FilamentPages\FilamentPages::class;
    }
}
