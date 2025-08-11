<?php

namespace App\Models\EventModels;

use MongoDB\Laravel\Eloquent\Model;

/**
 * @property string $_id 3 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 3 occurrences
 * @property string|null $email 2 occurrences
 * @property int|null $image_viewed 3 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 3 occurrences
 * @property string|null $user_id 1 occurrences
 * @property string|null $viewed_at 3 occurrences
 * @property-read mixed $id
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent aggregate($function = null, $columns = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent newQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent whereEmail($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent whereImageViewed($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent whereUpdatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent whereUserId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent whereViewedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|ImageViewedEvent vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @mixin \Eloquent
 */
class ImageViewedEvent extends Model
{

    protected $connection = 'mongodb';

    protected $collection = 'image_viewed_events';
}
