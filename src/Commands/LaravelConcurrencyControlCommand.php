<?php

namespace AjGulati05\LaravelConcurrencyControl\Commands;

use Illuminate\Console\Command;

class LaravelConcurrencyControlCommand extends Command
{
    public $signature = 'laravel-concurrency-control';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
