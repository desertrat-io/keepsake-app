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

namespace App\Repositories\ImageRepositories;

use App\DTO\Images\BookmarkData;
use App\Models\ImageModels\Bookmark;
use App\Repositories\KeepsakeEloquentRepository;
use App\Repositories\RepositoryContracts\BookmarkRepositoryContract;

class BookmarkEloquentRepository implements KeepsakeEloquentRepository, BookmarkRepositoryContract
{
    public function upsertBookmark(BookmarkData $bookmarkData): BookmarkData
    {
        Bookmark::upsert(values: [
            'uuid' => $bookmarkData->uuid,
            'bookmark_label' => $bookmarkData->bookmarkLabel,
            'created_by' => $bookmarkData->createdBy->id,
            'image_id' => $bookmarkData->image->id
        ], uniqueBy: ['image_id'], update: ['bookmark_label']);
        // we want to make sure the updated_at timestamp is refreshed
        return BookmarkData::fromModel(Bookmark::whereUuid($bookmarkData->uuid)->with('image')->first());
    }

    public function getBookmarksForImage(int $imageId): BookmarkData
    {
        return BookmarkData::from([]);
    }

    public function concreteEntityClass(): string
    {
        return Bookmark::class;
    }


}
