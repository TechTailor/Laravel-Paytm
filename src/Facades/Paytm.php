<?php

namespace TechTailor\Paytm\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TechTailor\Paytm\Paytm
 */
class Paytm extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TechTailor\Paytm\Paytm::class;
    }
}
