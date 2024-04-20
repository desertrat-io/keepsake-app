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

use App\DTO\DefaultIds;
use App\DTO\DefaultTimestamps;
use Carbon\Carbon;

class ImageMetaData
{
    use DefaultTimestamps;
    use DefaultIds;

    public readonly int $imageId;
    public readonly string $originalImageName;
    public readonly string $currentImageName;
    public readonly string $originalImageMime;
    public readonly int $originalFilesize;
    public readonly int $currentFileSize;
    public readonly string $originalFileExt;
    public readonly bool $isDeleted;
    public readonly ?ImageData $image;


    public function __construct(
        int $id,
        int $imageId,
        string $originalImageName,
        string $currentImageName,
        string $originalImageMime,
        int $originalFilesize,
        int $currentFileSize,
        string $originalFileExt,
        ?Carbon $createdAt,
        ?Carbon $updatedAt,
        ?Carbon $deletedAt,
        bool $isDeleted,
        ?ImageData $image
    ) {
        $this->imageId = $imageId;
        $this->originalImageName = $originalImageName;
        $this->currentImageName = $currentImageName;
        $this->originalImageMime = $originalImageMime;
        $this->originalFilesize = $originalFilesize;
        $this->currentFileSize = $currentFileSize;
        $this->originalFileExt = $originalFileExt;
        $this->image = $image;
        $this->isDeleted = $isDeleted;
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }


}
