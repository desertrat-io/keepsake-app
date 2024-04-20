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

use App\DTO\Images\ImageMetaData;
use App\Models\ImageModels\ImageMeta;
use App\Repositories\KeepsakeRepository;
use App\Repositories\RepositoryContracts\ImageMetaRepositoryContract;
use Override;

class ImageMetaEloquentRepository implements ImageMetaRepositoryContract, KeepsakeRepository
{
    #[Override] public function concreteEntityClass(): string
    {
        return ImageMeta::class;
    }

    #[Override] public function createImageMeta(ImageMetaData $imageMetaData): ImageMetaData
    {
        $imageMeta = ImageMeta::create([
            'image_id' => $imageMetaData->image->id,
            'original_image_name' => $imageMetaData->originalImageName,
            'original_image_mime' => $imageMetaData->originalImageMime,
            'current_image_name' => $imageMetaData->currentImageName,
            'original_filesize' => $imageMetaData->originalFilesize,
            'original_file_ext' => $imageMetaData->originalFileExt,
            'current_filesize' => $imageMetaData->currentFilesize
        ]);
        return ImageMetaData::from($imageMeta);
    }


}
