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

use App\Models\BoolDeleteColumn;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\ImageModels\ImageMeta
 *
 * @property int $id
 * @property int $image_id
 * @property string $original_image_name
 * @property string $current_image_name
 * @property string $original_image_mime
 * @property int $original_filesize in bytes
 * @property string $current_filesize
 * @property string $original_file_ext
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Image|null $image
 * @method static Builder|ImageMeta newModelQuery()
 * @method static Builder|ImageMeta newQuery()
 * @method static Builder|ImageMeta onlyTrashed()
 * @method static Builder|ImageMeta query()
 * @method static Builder|ImageMeta whereCreatedAt($value)
 * @method static Builder|ImageMeta whereCurrentFilesize($value)
 * @method static Builder|ImageMeta whereCurrentImageName($value)
 * @method static Builder|ImageMeta whereDeletedAt($value)
 * @method static Builder|ImageMeta whereId($value)
 * @method static Builder|ImageMeta whereImageId($value)
 * @method static Builder|ImageMeta whereOriginalFileExt($value)
 * @method static Builder|ImageMeta whereOriginalFilesize($value)
 * @method static Builder|ImageMeta whereOriginalImageMime($value)
 * @method static Builder|ImageMeta whereOriginalImageName($value)
 * @method static Builder|ImageMeta whereUpdatedAt($value)
 * @method static Builder|ImageMeta withTrashed()
 * @method static Builder|ImageMeta withoutTrashed()
 * @property-read mixed $is_deleted
 * @mixin Eloquent
 */
class ImageMeta extends Model
{
    use SoftDeletes;
    use BoolDeleteColumn;

    protected $table = 'image_meta';

    protected $fillable = [
        'image_id',
        'original_image_name',
        'original_image_mime',
        'current_image_name',
        'original_filesize',
        'original_file_ext',
        'current_filesize'
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
