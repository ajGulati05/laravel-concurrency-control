<?php

namespace AjGulati05\LaravelConcurrencyControl\Tests;

use Illuminate\Database\Eloquent\Model;
use AjGulati05\LaravelConcurrencyControl\Versioned;

class TestModel extends Model
{
    use Versioned;

    public $table = 'test_models';

    protected $guarded = [];
   
  
}