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

namespace App\DTO\Images;

use App\Models\ImageModels\ImageMeta;
use Carbon\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ImageMetaData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public readonly ?int $id,
        public readonly ?int $imageId,
        public readonly ?string $originalImageName,
        public readonly ?string $currentImageName,
        public readonly ?string $originalImageMime,
        public readonly ?int $originalFilesize,
        public readonly ?int $currentFilesize,
        public readonly ?string $originalFileExt,
        public readonly ?Carbon $createdAt,
        public readonly ?Carbon $updatedAt,
        public readonly ?Carbon $deletedAt,
        public readonly ?bool $isDeleted,
        public readonly ImageData|Lazy $image
    ) {
    }

    public static function fromModel(ImageMeta $imageMeta): self
    {
        return new self(
            id: $imageMeta->id,
            imageId: $imageMeta->image_id,
            originalImageName: $imageMeta->original_image_name,
            currentImageName: $imageMeta->current_image_name,
            originalImageMime: $imageMeta->original_image_mime,
            originalFilesize: $imageMeta->original_filesize,
            currentFilesize: $imageMeta->current_filesize,
            originalFileExt: $imageMeta->original_file_ext,
            createdAt: $imageMeta->created_at,
            updatedAt: $imageMeta->updated_at,
            deletedAt: $imageMeta->deleted_at,
            isDeleted: $imageMeta->is_deleted,
            image: Lazy::create(fn () => ImageData::fromModel($imageMeta->image))
        );
    }


}
