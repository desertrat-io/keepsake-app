<?php

namespace App\Services\DocumentServices;

use App\DTO\Documents\DocumentData;
use App\DTO\Images\ImageData;
use App\Events\Images\PdfUploaded;
use App\Exceptions\KeepsakeExceptions\KeepsakeStorageException;
use App\Repositories\RepositoryContracts\DocumentRepositoryContract as DocumentRepository;
use App\Repositories\RepositoryContracts\ImageRepositoryContract as ImageRepository;
use App\Repositories\RepositoryContracts\UserRepositoryContract as UserRepository;
use App\Services\KeepsakeService;
use App\Services\ServiceContracts\DocumentServiceContract;
use Auth;
use Illuminate\Http\UploadedFile;
use Keepsake;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Override;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

readonly class DocumentService implements DocumentServiceContract, KeepsakeService
{
    public function __construct(
        private DocumentRepository $documentRepository,
        private UserRepository     $userRepository,
        private ImageRepository    $imageRepository
    )
    {
    }

    /**
     * Makes the document ready for conversion but doesn't actually do the conversion
     * @param TemporaryUploadedFile $uploadedFile
     * @param string|null $customTitle
     * @return DocumentData
     * @throws KeepsakeStorageException
     */
    #[Override]
    public function createDocument(
        UploadedFile $uploadedFile,
        ?string      $customTitle = null,
        ?ImageData   $imageData = null,
    ): DocumentData
    {
        $storagePath = Keepsake::getNewStoragePath();
        $documentFileName = explode('.', $customTitle ?? $uploadedFile->getClientOriginalName())[0];
        $documentFileNameWithExt = $documentFileName . '.' . $uploadedFile->getClientOriginalExtension();
        $isUploaded = $uploadedFile->storeAs(
            path: $storagePath,
            name: $documentFileNameWithExt,
            options: 's3'
        );
        if (!$isUploaded) {
            $exception = new KeepsakeStorageException('Document upload to S3 failed');
            Keepsake::logException($exception);
            throw $exception;
        }

        // make sure to update the image immediately after creating, don't access the lazy property else
        // it'll resolve to nothing
        // also the storage_id of the base PDF and the initial image entry have to match
        $uploadedBy = $this->userRepository->getUserById(Auth::id(), asData: true);
        $documentData = $this->documentRepository->createDocument(DocumentData::from([
            'storage_id' => $imageData->storageId,
            'title' => $documentFileName,
            'uploadedBy' => $uploadedBy,
            'image_id' => $imageData->id,
        ]));
        $newData = $documentData->toArray();
        $newData['image'] = $imageData;
        $newData['uploadedBy'] = $uploadedBy;
        // free up some memory by overwriting the original document data
        $documentData = DocumentData::from($newData);
        event(new PdfUploaded($documentData));
        return $documentData;
    }


    /**
     * @param string $documentUUID
     * @return DataCollection<ImageData>|Lazy
     */
    #[Override]
    public function getDocumentThumbnails(string $documentUUID): DataCollection|Lazy
    {
        return $this->documentRepository->getDocumentThumbnails($documentUUID)->pages;
    }


}
