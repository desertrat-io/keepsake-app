<?php

/*
 * Copyright (c) 2023
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

namespace App\Models\ImageModels;

use App\DTO\Images\ImageData;
use App\Models\AccountModels\User;
use App\Models\BoolDeleteColumn;
use App\Models\DocumentModels\Document;
use App\Models\GenerateUUID;
use Database\Factories\ImageModels\ImageFactory;
use Eloquent;
use Faker\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\WithData;

/**
 * App\Models\ImageModels\ImageFacade
 *
 * @property int $id
 * @property string $uuid
 * @property string $storage_id
 * @property string $storage_path
 * @property int $uploaded_by
 * @property bool $is_locked
 * @property bool $is_dirty
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read ImageMeta|null $meta
 * @method static Builder|Image newModelQuery()
 * @method static Builder|Image newQuery()
 * @method static Builder|Image onlyTrashed()
 * @method static Builder|Image query()
 * @method static Builder|Image whereCreatedAt($value)
 * @method static Builder|Image whereDeletedAt($value)
 * @method static Builder|Image whereId($value)
 * @method static Builder|Image whereIsDirty($value)
 * @method static Builder|Image whereIsLocked($value)
 * @method static Builder|Image whereStorageId($value)
 * @method static Builder|Image whereStoragePath($value)
 * @method static Builder|Image whereUpdatedAt($value)
 * @method static Builder|Image whereUploadedBy($value)
 * @method static Builder|Image whereUuid($value)
 * @method static Builder|Image withTrashed()
 * @method static Builder|Image withoutTrashed()
 * @property-read User|null $uploadedBy
 * @property-read mixed $is_deleted
 * @property int|null $document_id
 * @method static Builder<static>|Image whereDocumentId($value)
 * @property-read Document|null $pageOf
 * @property-read TFactory|null $use_factory
 * @method static ImageFactory factory($count = null, $state = [])
 * @property int|null $parent_image_id
 * @method static Builder<static>|Image whereParentImageId($value)
 * @property-read Image|null $parent
 * @mixin Eloquent
 */
class Image extends Model
{
    use SoftDeletes;
    use BoolDeleteColumn;
    use GenerateUUID;
    use HasFactory;
    use WithData;

    protected string $dataClass = ImageData::class;


    protected $fillable = [
        'uuid',
        'parent_image_id',
        'storage_id',
        'storage_path',
        'uploaded_by',
        'is_locked',
        'is_dirty',
        'document_id'
    ];

    protected static function newFactory(): ImageFactory|Factory
    {
        return ImageFactory::new();
    }

    public function meta(): HasOne
    {
        return $this->hasOne(ImageMeta::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'uploaded_by');
    }

    public function pageOf(): HasOne
    {
        return $this->hasOne(Document::class);
    }

    public function parent(): HasOne
    {
        return $this->hasOne(Image::class, 'parent_image_id');
    }

    protected function casts(): array
    {
        return [
            'uuid' => 'string'
        ];
    }
}
