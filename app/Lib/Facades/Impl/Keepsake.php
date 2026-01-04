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

namespace App\Lib\Facades\Impl;

use App\DTO\Images\ImageData;
use App\Events\Errors\KeepsakeExceptionThrown;
use App\Exceptions\KeepsakeExceptions\KeepsakeException;
use App\Models\ImageModels\Image;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Str;

class Keepsake
{
    public function idFromKey(string $keepsakeKey): UuidInterface
    {
        return Uuid::fromString(Str::replace('keepsake-key-', '', $keepsakeKey));
    }

    public function idToKey(UuidInterface|string $keepsakeKey): string
    {
        if ($keepsakeKey instanceof UuidInterface) {
            return 'keepsake-key-' . $keepsakeKey->toString();
        }
        return 'keepsake-key-' . $keepsakeKey;
    }

    public function logException(KeepsakeException $exception): void
    {
        event(new KeepsakeExceptionThrown($exception));
    }

    public function getNewStoragePath(): string
    {
        return 'media/images/' . config('keepsake.tenant_name', env('DEFAULT_TENANT_NAME')) . '/' . Str::orderedUuid();
    }

    public function getCurrentDiskName(): string
    {
        $diskName = 's3';
        if (app()->environment('testing')) {
            $diskName = $this->getTestDiskName();
        }
        return $diskName;
    }

    public function getTestDiskName(): string
    {
        $diskName = $this->getLocalDiskName();
        if (!app()->environment('local')) {
            $diskName = config('keepsake.test_disk_name');
        }
        return $diskName;
    }

    public function getLocalDiskName(): string
    {
        return config('keepsake.local_disk_name');
    }

    /**
     * We're taking both to support eloquent models and data transfer objects.
     */
    public function getPathToImage(ImageData|Image $image): string
    {
        $imageData = $image;
        if ($image instanceof Image) {
            $imageData = ImageData::fromModel($image);
        }

        return $image->storage_path . '/' . $image->meta->current_image_name . '.' . $image->meta->original_file_ext;
    }
}
