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

namespace App\Models\ImageModels;

use App\DTO\Images\BookmarkData;
use App\Models\AccountModels\User;
use App\Models\BoolDeleteColumn;
use App\Models\GenerateUUID;
use Database\Factories\ImageModels\BookmarkFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\WithData;

/**
 * @property int $id
 * @property string $uuid
 * @property string $bookmark_label
 * @property int $image_id
 * @property int $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static Builder<static>|Bookmark newModelQuery()
 * @method static Builder<static>|Bookmark newQuery()
 * @method static Builder<static>|Bookmark query()
 * @method static Builder<static>|Bookmark whereBookmarkLabel($value)
 * @method static Builder<static>|Bookmark whereCreatedAt($value)
 * @method static Builder<static>|Bookmark whereCreatedBy($value)
 * @method static Builder<static>|Bookmark whereDeletedAt($value)
 * @method static Builder<static>|Bookmark whereId($value)
 * @method static Builder<static>|Bookmark whereImageId($value)
 * @method static Builder<static>|Bookmark whereUpdatedAt($value)
 * @method static Builder<static>|Bookmark whereUuid($value)
 * @property-read User $createdBy
 * @property-read \App\Models\ImageModels\Image $image
 * @property-read mixed $is_deleted
 * @method static \Database\Factories\ImageModels\BookmarkFactory factory($count = null, $state = [])
 * @method static Builder<static>|Bookmark onlyTrashed()
 * @method static Builder<static>|Bookmark withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Bookmark withoutTrashed()
 * @mixin Eloquent
 */
class Bookmark extends Model
{

    use SoftDeletes;
    use BoolDeleteColumn;
    use GenerateUUID;
    use HasFactory;
    use WithData;

    protected string $dataClass = BookmarkData::class;
    protected $fillable = [
        'uuid',
        'bookmark_label',
        'image_id',
        'created_by'
    ];

    protected static function newFactory(): Factory|BookmarkFactory
    {
        return BookmarkFactory::new();
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'created_by', ownerKey: 'id');
    }

    protected function casts(): array
    {
        return [
            'uuid' => 'string'
        ];
    }
}
