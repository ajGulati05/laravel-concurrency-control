<?php

namespace AjGulati05\LaravelConcurrencyControl\Tests;

use AjGulati05\LaravelConcurrencyControl\Versioned;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\DB;
use RuntimeException;

beforeEach(function () {

    $this->model = new class extends \Illuminate\Database\Eloquent\Model
    {
        use Versioned;

        protected $guarded = [];


        protected $table = 'test';
    };

    DB::statement('CREATE TABLE test (id INTEGER PRIMARY KEY, name TEXT, created_at DATETIME,updated_at DATETIME)');
});


it('boots versioned', function () {

    $this->model->fill(['name' => 'Test', 'updated_at' => Carbon::now()])->save();
    $this->assertArrayHasKey('versionId', $this->model->toArray());
});

it('checks the version attribute as timestamp is equal', function () {

    $now = Carbon::now();
    $this->model->fill(['name' => 'Test', 'updated_at' => $now])->save();
    $this->assertEquals($now->timestamp, $this->model->versionId);
});

it('Tests the getVersionedColumn function', function () {

    Config::set('concurrency.version_datetime', 'name');
    $this->expectException(RuntimeException::class);
    $this->model->getVersionedColumn();
});

it('Tests the validateVersionedColumn function ', function () {

    $this->model2 = new class extends \Illuminate\Database\Eloquent\Model
    {
        use Versioned;

        protected $guarded = [];

        protected $table = 'test';

        public function publicValidateVersionedColumn($column)
        {
            return $this->validateVersionedColumn($column);
        }
    };

    $this->expectException(RuntimeException::class);
    $this->model2->publicValidateVersionedColumn('unknown_column');

});

it('Tests the update function ', function () {
    $now = Carbon::now();
    $this->model->fill(['name' => 'Test', 'updated_at' => $now])->save();

    $this->model->update(['name' => 'New Test', 'versionId' => $now->timestamp]);

    $this->assertEquals('New Test', $this->model->name);
});

it('Tests the updateWithoutExpectingVersionId function ', function () {
    $this->model->fill(['name' => 'Test', 'updated_at' => Carbon::now()])->save();

    $this->model->updateWithoutExpectingVersionId(['name' => 'New Test']);

    $this->assertEquals('New Test', $this->model->name);
});
