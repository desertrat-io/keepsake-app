<?php

namespace App\Models\EventModels;

use MongoDB\Laravel\Eloquent\Model;

/**
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
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @property \Illuminate\Support\Carbon|null $created_at 9 occurrences
 * @property int|null $http_error_code 9 occurrences
 * @property string|null $message 9 occurrences
 * @property int|null $response_code 9 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 9 occurrences
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent whereHttpErrorCode($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent whereMessage($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent whereResponseCode($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|KeepsakeExceptionEvent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class KeepsakeExceptionEvent extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'keepsake_error_events';
}
