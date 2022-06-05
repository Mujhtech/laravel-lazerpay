<?php

/*
 *
 * (c) Muhideen Mujeeb Adeoye <mujeeb.muhideen@gmail.com>
 *
 */
namespace Mujhtech\Lazerypay\Facades;

use Illuminate\Support\Facades\Facade;

class Lazerypay extends Facade
{
    /**
     * Get the registered name of the component
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-lazerpay';
    }
}