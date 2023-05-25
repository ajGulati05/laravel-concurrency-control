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

        static::saving(function ($model) {
            $model->append('versionId');
        });
        static::retrieved(function ($model) {
            $model->append('versionId');
        });
    }

   // Add versionId to model
   public function getVersionIdAttribute()
   {
       $column = $this->getVersionedColumn();

       return $this->{$column}->timestamp;
   }
     // Get the versioned column name from configuration
   public  function getVersionedColumn(): string
    {
        $column= config('concurrency.version_datetime', 'updated_at');
        $this->validateVersionedColumn($column);
        return $column;
    }
 
  

   // Validate the versioned column
   protected function validateVersionedColumn($column)
   {
       $table = $this->getTable();

       $columnType = DB::connection($this->getConnectionName())
           ->getDoctrineColumn($table, $column)
           ->getType()
           ->getName();

       if ($columnType !== 'datetime') {
           throw new \RuntimeException("The versioned column '{$column}' on table '{$table}' must be of type 'datetime'.");
       }
   }

   // Update the model
   public function update(array $attributes = [], array $options = [])
   {
       // Expect versionId in attributes
       if (!isset($attributes['versionId'])) {
           abort(422, 'versionId is required');
       }

       // Match versionId with current versioned column timestamp
       $column = $this->getVersionedColumn();
       if (Carbon::createFromTimestamp($attributes['versionId'])->ne($this->{$column})) {
           abort(409, 'The resource has been updated since last retrieval. Please retrieve the resource again.');
       }

       // Remove versionId from attributes
       unset($attributes['versionId']);

       // Update the model
       return parent::update($attributes, $options);
   }

   // Update the model without expecting versionId
   public function updateWithoutExpectingVersionId(array $attributes = [], array $options = [])
   {
       // Remove versionId from attributes
       unset($attributes['versionId']);

       // Update the model
       return parent::update($attributes, $options);
   }

}
