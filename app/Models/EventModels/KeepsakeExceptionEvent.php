<?php

namespace App\Models\EventModels;

use MongoDB\Laravel\Eloquent\Model;

/**
 * 
 *
 * @property-read mixed $id
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent aggregate($function = null, $columns = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent newQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent raw($value = null)
 * @mixin \Eloquent
 */
class KeepsakeExceptionEvent extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'keepsake_error_events';
}
