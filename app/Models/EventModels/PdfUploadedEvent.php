<?php

namespace App\Models\EventModels;

use MongoDB\Laravel\Eloquent\Model;

/**
 * @property string $_id 3 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 3 occurrences
 * @property string|null $document_name 3 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 3 occurrences
 * @property int|null $uploaded_id 3 occurrences
 * @property string|null $uploader 3 occurrences
 * @property-read mixed $id
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent aggregate($function = null, $columns = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent newQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent whereDocumentName($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent whereUpdatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent whereUploadedId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent whereUploader($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PdfUploadedEvent vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @mixin \Eloquent
 */
class PdfUploadedEvent extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'pdf_uploaded_events';
}
