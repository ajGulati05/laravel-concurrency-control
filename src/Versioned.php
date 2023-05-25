<?php
namespace AjGulati05\LaravelConcurrencyControl;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

trait Versioned
{
    // This is called when the trait is used in a model
    public static function bootVersioned()
    {
        // Add versionId when converting to array or json
        static::retrieved(function ($model) {
            $model->append('versionId');
        });
    }

    // Add versionId to model
    public function getVersionIdAttribute()
    {
        return $this->updated_at->timestamp;
    }

    // Update the model
    public function update(array $attributes = [], array $options = [])
    {
        // Expect versionId in attributes
        if (!isset($attributes['versionId'])) {
            abort(422, 'versionId is required');
        }

        // Match versionId with current updated_at timestamp
        if (Carbon::createFromTimestamp($attributes['versionId'])->ne($this->updated_at)) {
            abort(409, 'The resource has been updated since last retrieval. Please retrieve the resource again.');
        }

        // Update the model
        return $this->update($attributes, $options);
    }

    // Update the model without expecting versionId
    public function updateWithoutExpectingVersionId(array $attributes = [], array $options = [])
    {
        // Remove versionId from attributes
        unset($attributes['versionId']);

        // Update the model
        return $this->update($attributes, $options);
    }
}
