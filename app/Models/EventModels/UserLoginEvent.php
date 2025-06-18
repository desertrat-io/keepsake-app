<?php
/*
 * Copyright (c) 2025
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this
 * software and associated documentation files (the "Software"), to deal in the Software
 * without restriction, including without limitation the rights to use, copy, modify, merge,
 *  publish, distribute, sublicense, and/or sell copies of the Software, and to permit
 *  persons to whom the Software is furnished to do so, subject to the following
 *  conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPIRES
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NON INFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
declare(strict_types=1);

namespace App\Models\EventModels;

use MongoDB\Laravel\Eloquent\Model;

/**
 * 
 *
 * @property mixed $id 3 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 3 occurrences
 * @property string|null $from_ip 3 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 3 occurrences
 * @property string|null $user_uuid 3 occurrences
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent aggregate($function = null, $columns = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent newQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent whereFromIp($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent whereUpdatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserLoginEvent whereUserUuid($value)
 * @mixin \Eloquent
 */
class UserLoginEvent extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'user_login_events';
}
