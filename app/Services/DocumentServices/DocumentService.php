<?php

namespace App\Services\DocumentServices;

use App\DTO\Documents\DocumentData;
use App\Events\Images\PdfUploaded;
use App\Exceptions\KeepsakeExceptions\KeepsakeStorageException;
use App\Repositories\RepositoryContracts\DocumentRepositoryContract as DocumentRepository;
use App\Repositories\RepositoryContracts\UserRepositoryContract as UserRepository;
use App\Services\KeepsakeService;
use App\Services\ServiceContracts\DocumentServiceContract;
use Auth;
use Illuminate\Http\UploadedFile;
use Keepsake;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Override;

class DocumentService implements DocumentServiceContract, KeepsakeService
{
    public function __construct(private readonly DocumentRepository $documentRepository, private readonly UserRepository $userRepository)
    {
    }

    /**
     * Makes the document ready for conversion but doesn't actually do the conversion
     * @param TemporaryUploadedFile $temporaryUploadedFile
     * @param string|null $customTitle
     * @return DocumentData
     * @throws KeepsakeStorageException
     */
    #[Override]
    public function createDocument(
        UploadedFile $temporaryUploadedFile,
        ?string      $customTitle = null
    ): DocumentData
    {
        $storagePath = Keepsake::getNewStoragePath();
        $documentFileName = explode('.', $customTitle ?? $temporaryUploadedFile->getClientOriginalName())[0];
        $documentFileNameWithExt = $documentFileName . '.' . $temporaryUploadedFile->getClientOriginalExtension();
        $storageId = $temporaryUploadedFile->storeAs(
            path: $storagePath,
            name: $documentFileNameWithExt,
            options: 's3'
        );
        if (!$storageId) {
            $exception = new KeepsakeStorageException('Document upload to S3 failed');
            Keepsake::logException($exception);
            throw $exception;
        }
        $documentData = $this->documentRepository->createDocument(DocumentData::from([
            'storage_id' => $storageId,
            'title' => $documentFileName,
            'uploadedBy' => $this->userRepository->getUserById(Auth::id(), asData: true)
        ]));
        event(new PdfUploaded($documentData));
        return $documentData;
    }
}
