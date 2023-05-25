<?php

use AjGulati05\LaravelConcurrencyControl\Tests\TestModel;

beforeEach(function () {
    $this->testModel = TestModel::create(['name' => 'default']);
});

it('provides versionId as a property on the test Model', function () {

    dd($this->testModel->toArray());

});
