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

namespace App\Services\ServiceContracts;

use App\DTO\Accounts\UserData;
use App\DTO\Images\ImageData;
use App\DTO\Images\ImageMetaData;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\Cursor;

interface ImageServiceContract
{
    public function saveImage(UploadedFile $uploadedFile, ?string $customTitle = null, ?string $customPath = null, int|string|null $customUploader = null, ?int $documentId = null, ?int $parentImageId = null): ImageData;

    public function saveThumbnail(UploadedFile $uploadedFile, string $imageName, string $storagePath): string|bool;

    public function getImages(
        int     $total = 100,
        int     $page = 1,
        int     $perPage = 0,
        string  $pageName = 'page',
        bool    $useCursor = false,
        ?Cursor $cursor = null
    ): CursorPaginator|Paginator;

    public function createImageData(string|bool $storageId, string $storagePath, UserData $uploadedBy, UploadedFile $uploadedFile, ?int $documentId = null, ?int $parentImageId = null): ImageData;

    public function createImageMetaData(
        ImageData    $imageData,
        UploadedFile $uploadedFile,
        string       $imageName
    ): ImageMetaData;

    public function imageProcessed(string $storageId): void;

}
