<?php

namespace AjGulati05\LaravelConcurrencyControl\Tests;

use AjGulati05\LaravelConcurrencyControl\Versioned;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use Versioned;

    public $table = 'test_models';

    protected $guarded = [];
}
