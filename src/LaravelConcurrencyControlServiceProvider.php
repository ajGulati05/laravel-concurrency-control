<?php

namespace AjGulati05\LaravelConcurrencyControl;

use AjGulati05\LaravelConcurrencyControl\Commands\LaravelConcurrencyControlCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelConcurrencyControlServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-concurrency-control')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-concurrency-control_table')
            ->hasCommand(LaravelConcurrencyControlCommand::class);
    }
}
