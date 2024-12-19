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

namespace App\Services\ImageServices;

use App\DTO\Accounts\UserData;
use App\DTO\Images\ImageData;
use App\DTO\Images\ImageMetaData;
use App\Events\ImageUploaded;
use App\Exceptions\KeepsakeExceptions\KeepsakeStorageException;
use App\Repositories\RepositoryContracts\ImageMetaRepositoryContract;
use App\Repositories\RepositoryContracts\ImageRepositoryContract;
use App\Repositories\RepositoryContracts\UserRepositoryContract;
use App\Services\KeepsakeService;
use App\Services\ServiceContracts\ImageServiceContract;
use Auth;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Pagination\Cursor;
use Image;
use Keepsake;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Override;
use Storage;

class ImageService implements ImageServiceContract, KeepsakeService
{
    public function __construct(
        private ImageRepositoryContract $imageRepository,
        private ImageMetaRepositoryContract $imageMetaRepository,
        private UserRepositoryContract $userRepository
    ) {
    }

    /**
     * @throws KeepsakeStorageException
     */
    #[Override]
    public function saveImage(TemporaryUploadedFile $temporaryUploadedFile, ?string $customTitle = null): ImageData
    {
        $imageName = explode('.', $customTitle ?? $temporaryUploadedFile->getClientOriginalName())[0];
        $storagePath = Keepsake::getNewStoragePath();
        // livewire doesn't decorate the file handler so that you can mutate it before storing...to my knowledge

        $thumbNail = Image::read($temporaryUploadedFile);
        $thumbNail->scaleDown(width: 128, height: 128);
        $storageId = Storage::disk('s3')->putFileAs(
            path: $storagePath,
            file: $thumbNail->toJpeg()->toDataUri(),
            name: "$imageName.thumb.{$temporaryUploadedFile->getClientOriginalExtension()}"
        );
        if (!$storageId) {
            $exception = new KeepsakeStorageException('Image upload to S3 failed');
            Keepsake::logException($exception);
            throw $exception;
        }
        $temporaryUploadedFile->storeAs(
            path: $storagePath,
            name: $imageName . '.' . $temporaryUploadedFile->getClientOriginalExtension(),
            options: 's3'
        );
        $imageData = $this->createImageData(
            $storageId,
            $storagePath,
            uploadedBy: $this->userRepository->getUserById(
                Auth::id(),
                asData: true
            )
        );
        $imageData = $insertedImageData = $this->imageRepository->createImage($imageData);
        $imageMetaData = $this->createImageMetaData($insertedImageData, $temporaryUploadedFile, $imageName);
        $this->imageMetaRepository->createImageMeta($imageMetaData);
        event(new ImageUploaded($imageData, $imageMetaData));

        return $imageData;
    }

    private function createImageData(string|bool $storageId, string $storagePath, UserData $uploadedBy): ImageData
    {
        return ImageData::from(
            ['storageId' => $storageId, 'storagePath' => $storagePath, 'uploadedBy' => $uploadedBy]
        );
    }

    private function createImageMetaData(
        ImageData $imageData,
        TemporaryUploadedFile $temporaryUploadedFile,
        string $imageName
    ): ImageMetaData {
        return ImageMetaData::from(
            [
                'originalImageName' => $temporaryUploadedFile->getClientOriginalName(),
                'currentImageName' => $imageName,
                'originalImageMime' => $temporaryUploadedFile->getClientMimeType(),
                'originalFilesize' => $temporaryUploadedFile->getSize(),
                'currentFilesize' => $temporaryUploadedFile->getSize(),
                'originalFileExt' => $temporaryUploadedFile->getClientOriginalExtension(),
                'image' => $imageData,
            ]
        );
    }

    #[Override]
    public function getImages(
        int $total = 100,
        int $page = 1,
        ?int $perPage = null,
        ?Cursor $cursor = null
    ): CursorPaginator {
        // TODO: make sure this is tenant specific
        $per = $perPage;
        if (is_null($per)) {
            $per = 0;
        }

        return $this->imageRepository->getImages(cursor: $cursor, perPage: $per, limit: $total);
    }


}
