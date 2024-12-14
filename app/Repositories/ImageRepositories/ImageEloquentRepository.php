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

namespace App\Repositories\ImageRepositories;

use App\DTO\Accounts\UserData;
use App\DTO\Images\ImageData;
use App\Models\ImageModels\Image;
use App\Repositories\KeepsakeEloquentRepository;
use App\Repositories\RepositoryContracts\ImageRepositoryContract;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Collection;
use Override;

class ImageEloquentRepository implements ImageRepositoryContract, KeepsakeEloquentRepository
{
    #[Override] public function concreteEntityClass(): string
    {
        return Image::class;
    }

    #[Override] public function createImage(ImageData $imageData): ImageData
    {
        $image = Image::create([
            'storage_id' => $imageData->storageId,
            'storage_path' => $imageData->storagePath,
            'is_locked' => false,
            'is_dirty' => true,
            'uploaded_by' => $imageData->uploadedBy->id
        ])->load('uploadedBy');
        // some kind of weird quirk with spatie data, you end up having to create the model, then query it
        return ImageData::fromModel($image);
    }

    #[Override] public function getImagePaths(array|int $ids): Collection|string
    {
        if (gettype($ids) === 'integer') {
            return Image::whereId($ids)->orderByDesc('created_at')->storage_path;
        }

        return Image::whereIn('id', $ids)->orderByDesc('created_at')->get(['storage_path']);
    }

    /**
     * @param string|null $cursor
     * @param int $perPage
     * @param int $limit
     * @return CursorPaginator
     */
    #[Override] public function getImages(?string $cursor = null, int $perPage = 10, int $limit = 100): CursorPaginator
    {
        return
            Image::with(['meta', 'uploadedBy'])->limit($limit)->orderByDesc(
                'created_at'
            )->cursorPaginate(perPage: $perPage, columns: [
                'id',
                'uuid',
                'storage_id',
                'storage_path',
                'created_at',
                'uploaded_by',
                'is_dirty'
            ], cursor: $cursor);
    }


}
