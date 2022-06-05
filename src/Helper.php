<?php

/*
 *
 * (c) Muhideen Mujeeb Adeoye <mujeeb.muhideen@gmail.com>
 *
 */

if (!function_exists("lazerpay")) {
    function lazerpay()
    {

        return app()->make('laravel-lazerpay');
    }
}
