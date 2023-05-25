<?php

namespace AjGulati05\LaravelConcurrencyControl\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AjGulati05\LaravelConcurrencyControl\LaravelConcurrencyControl
 */
class LaravelConcurrencyControl extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \AjGulati05\LaravelConcurrencyControl\LaravelConcurrencyControl::class;
    }
}
