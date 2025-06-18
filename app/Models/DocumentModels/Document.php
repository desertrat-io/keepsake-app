<?php

namespace App\Models\DocumentModels;

use App\Models\AccountModels\User;
use App\Models\BoolDeleteColumn;
use App\Models\GenerateUUID;
use App\Models\ImageModels\Image;
use Database\Factories\DocumentModels\DocumentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property string $uuid
 * @property string $title
 * @property int $num_pages
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static Builder<static>|Document newModelQuery()
 * @method static Builder<static>|Document newQuery()
 * @method static Builder<static>|Document query()
 * @method static Builder<static>|Document whereCreatedAt($value)
 * @method static Builder<static>|Document whereDeletedAt($value)
 * @method static Builder<static>|Document whereId($value)
 * @method static Builder<static>|Document whereNumPages($value)
 * @method static Builder<static>|Document whereTitle($value)
 * @method static Builder<static>|Document whereUpdatedAt($value)
 * @method static Builder<static>|Document whereUuid($value)
 * @property int|null $uploaded_by
 * @property-read mixed $is_deleted
 * @property-read Collection<int, Image> $pages
 * @property-read int|null $pages_count
 * @method static Builder<static>|Document onlyTrashed()
 * @method static Builder<static>|Document whereUploadedBy($value)
 * @method static Builder<static>|Document withTrashed()
 * @method static Builder<static>|Document withoutTrashed()
 * @property string|null $storage_id
 * @property-read User|null $uploadedBy
 * @method static Builder<static>|Document whereStorageId($value)
 * @method static \Database\Factories\DocumentModels\DocumentFactory factory($count = null, $state = [])
 * @mixin Eloquent
 */
class Document extends Model
{

    use GenerateUUID;
    use SoftDeletes;
    use BoolDeleteColumn;
    use HasFactory;

    protected $fillable = [
        'uuid',
        'title',
        'num_pages',
        'uploaded_by',
        'storage_id'
    ];

    protected static function newFactory(): DocumentFactory|Factory
    {
        return DocumentFactory::new();
    }

    public function pages(): HasMany
    {
        return $this->hasMany(related: Image::class, foreignKey: 'document_id', localKey: 'id');
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'uploaded_by');
    }

    protected function casts()
    {
        return ['uuid' => 'string'];
    }
}
