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

namespace App\DTO\Images;

use App\DTO\Accounts\UserData;
use App\Models\ImageModels\Bookmark;
use Carbon\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class BookmarkData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public readonly ?int                $id,
        public readonly ?string             $uuid,
        public readonly ?string             $bookmarkLabel,
        public readonly null|Lazy|ImageData $image,
        public readonly null|Lazy|UserData  $createdBy,
        public readonly ?Carbon             $createdAt,
        public readonly ?Carbon             $updatedAt,
        public readonly ?Carbon             $deletedAt,
        public readonly ?bool               $isDeleted
    ) {
    }

    public static function fromModel(?Bookmark $bookmark): self
    {
        return new self(
            id: $bookmark?->id,
            uuid: $bookmark?->uuid,
            bookmarkLabel: $bookmark?->bookmark_label,
            image: Lazy::create(fn () => ImageData::fromModel($bookmark?->image)),
            createdBy: Lazy::create(fn () => UserData::fromModel($bookmark?->createdBy)),
            createdAt: $bookmark?->created_at,
            updatedAt: $bookmark?->updated_at,
            deletedAt: $bookmark?->deleted_at,
            isDeleted: $bookmark?->is_deleted
        );
    }
}
