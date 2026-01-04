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
use App\Events\Images\ImageUploaded;
use App\Exceptions\KeepsakeExceptions\KeepsakeStorageException;
use App\Repositories\RepositoryContracts\BookmarkRepositoryContract;
use App\Repositories\RepositoryContracts\ImageMetaRepositoryContract;
use App\Repositories\RepositoryContracts\ImageRepositoryContract;
use App\Repositories\RepositoryContracts\UserRepositoryContract;
use App\Services\KeepsakeService;
use App\Services\ServiceContracts\ImageServiceContract;
use Auth;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\Cursor;
use Intervention\Image\Laravel\Facades\Image;
use Keepsake;
use Override;
use Storage;

readonly class ImageService implements ImageServiceContract, KeepsakeService
{
    public function __construct(
        private ImageRepositoryContract     $imageRepository,
        private ImageMetaRepositoryContract $imageMetaRepository,
        private UserRepositoryContract      $userRepository,
        private BookmarkRepositoryContract  $bookmarkRepository
    )
    {
    }

    /**
     * @throws KeepsakeStorageException
     */
    #[Override]
    public function saveImage(UploadedFile $uploadedFile, ?string $customTitle = null, ?string $customPath = null, int|string|null $customUploader = null, ?int $documentId = null, ?int $parentImageId = null, ?int $pageNumber = null): ImageData
    {
        $imageName = explode('.', $customTitle ?? $uploadedFile->getClientOriginalName())[0];
        // this should never ever be null. if it is, there are shenanigans
        $uploader = $customUploader ?? Auth::id();
        $storagePath = $customPath ?? Keepsake::getNewStoragePath();
        // livewire doesn't decorate the file handler so that you can mutate it before storing...to my knowledge
        // also as a result, we get back the storageId parameter after saving to disk explicitly, so we
        // need to capture that

        $storageId = $this->saveThumbnail(uploadedFile: $uploadedFile, imageName: $imageName, storagePath: $storagePath);

        if (!$storageId) {
            $exception = new KeepsakeStorageException('Image upload to ' . Keepsake::getCurrentDiskName() . ' failed');
            Keepsake::logException($exception);
            throw $exception;
        }

        // TODO: the pdf is going to get uploaded twice if this happens when the image is uploaded as pdf
        $uploadedFile->storeAs(
            path: $storagePath,
            name: $imageName . '.' . $uploadedFile->getClientOriginalExtension(),
            options: Keepsake::getCurrentDiskName()
        );
        $imageData = $this->createImageData(
            $storageId,
            $storagePath,
            uploadedBy: $this->userRepository->getUserById(
                $uploader,
                asData: true
            ),
            uploadedFile: $uploadedFile,
            documentId: $documentId,
            parentImageId: $parentImageId,
            pageNumber: $pageNumber
        );
        $insertedImageData = $this->imageRepository->createImage($imageData);
        $imageMetaData = $this->createImageMetaData($insertedImageData, $uploadedFile, $imageName);
        $this->imageMetaRepository->createImageMeta($imageMetaData);
        event(new ImageUploaded($insertedImageData, $imageMetaData));

        return $insertedImageData;
    }

    #[Override]
    public function saveThumbnail(UploadedFile $uploadedFile, string $imageName, string $storagePath): string|bool
    {
        // skip creation of a thumbnail and just save
        // TODO: refactor, duplicate code
        if ($uploadedFile->getClientOriginalExtension() === 'pdf') {
            return Storage::disk(Keepsake::getCurrentDiskName())->putFileAs(
                path: $storagePath,
                file: $uploadedFile,
                name: $imageName . '.' . $uploadedFile->getClientOriginalExtension()
            );
        }
        $thumbNail = Image::read($uploadedFile);
        $thumbNail->scaleDown(width: config('keepsake.thumbnail_scale_size'), height: config('keepsake.thumbnail_scale_size'));
        return Storage::disk(Keepsake::getCurrentDiskName())->putFileAs(
            path: $storagePath,
            file: $thumbNail->toJpeg()->toDataUri(),
            name: "$imageName.thumb.{$uploadedFile->getClientOriginalExtension()}"
        );
    }


    #[Override]
    public function createImageData(
        string|bool  $storageId,
        string       $storagePath,
        UserData     $uploadedBy,
        UploadedFile $uploadedFile,
        ?int         $documentId = null,
        ?int         $parentImageId = null,
        ?int         $pageNumber = null
    ): ImageData
    {
        $baseData = ['storageId' => $storageId, 'storagePath' => $storagePath, 'uploadedBy' => $uploadedBy];
        if ($documentId !== null) {
            $baseData['documentId'] = $documentId;
        }
        // dirty since the pdf has to be processed by the image converter service
        $baseData['isDirty'] = $uploadedFile->getClientOriginalExtension() === 'pdf';
        // no need to check anything, it's nullable across the whole data pipeline
        $baseData['parentImageId'] = $parentImageId;
        $baseData['pageNumber'] = $pageNumber;

        return ImageData::from($baseData);
    }

    #[Override]
    public function createImageMetaData(
        ImageData    $imageData,
        UploadedFile $uploadedFile,
        string       $imageName
    ): ImageMetaData
    {
        return ImageMetaData::from(
            [
                'originalImageName' => $uploadedFile->getClientOriginalName(),
                'currentImageName' => $imageName,
                'originalImageMime' => $uploadedFile->getClientMimeType(),
                'originalFilesize' => $uploadedFile->getSize(),
                'currentFilesize' => $uploadedFile->getSize(),
                'originalFileExt' => $uploadedFile->getClientOriginalExtension(),
                'image' => $imageData,
            ]
        );
    }

    /**
     * @param int $total
     * @param int $page
     * @param int $perPage
     * @param string $pageName
     * @param Cursor|null $cursor
     * @return CursorPaginator|Paginator
     */
    #[Override]
    public function getImages(
        int     $total = 100,
        int     $page = 1,
        int     $perPage = 0,
        string  $pageName = 'page',
        bool    $useCursor = false,
        ?Cursor $cursor = null
    ): CursorPaginator|Paginator
    {

        return $this->imageRepository->getImages(perPage: $perPage, limit: $total, pageName: $pageName, useCursor: $useCursor, cursor: $cursor);
    }

    public function imageProcessed(string $storageId): void
    {
        $this->imageRepository->markProcessed(storageId: $storageId);
    }

    public function getBookmarkLabel(int $imageId): string
    {
        $imageData = $this->imageRepository->getImageByID($imageId);
        if ($imageData->bookmark->bookmarkLabel === null) {
            return '';
        }
        return $imageData->bookmark->bookmarkLabel;
    }

    public function upsertBookmarkForImage(string $bookmarkLabel, string $imageId): void
    {
        // TODO: convert imageUUID to regular ID before inserting
        $this->bookmarkRepository->upsertBookmark($bookmarkLabel, $imageId);
    }


}
