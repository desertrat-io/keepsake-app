<?php

namespace App\Services\DocumentServices;

use App\DTO\Documents\DocumentData;
use App\Events\PdfUploaded;
use App\Exceptions\KeepsakeExceptions\KeepsakeStorageException;
use App\Repositories\RepositoryContracts\DocumentRepositoryContract as DocumentRepository;
use App\Repositories\RepositoryContracts\UserRepositoryContract as UserRepository;
use App\Services\KeepsakeService;
use App\Services\ServiceContracts\DocumentServiceContract;
use Auth;
use Keepsake;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class DocumentService implements DocumentServiceContract, KeepsakeService
{

    public function __construct(private DocumentRepository $documentRepository, private UserRepository $userRepository)
    {
    }

    /**
     * @throws KeepsakeStorageException
     */
    public function convertPdf(string $storageId): DocumentData
    {
        return DocumentData::from([]);
    }

    /**
     * Makes the document ready for conversion but doesn't actually do the conversion
     * @param TemporaryUploadedFile $temporaryUploadedFile
     * @param string|null $customTitle
     * @return DocumentData
     * @throws KeepsakeStorageException
     */
    public function createDocument(
        TemporaryUploadedFile $temporaryUploadedFile,
        ?string $customTitle = null
    ): DocumentData {
        $storagePath = Keepsake::getNewStoragePath();
        $documentFileName = explode('.', $customTitle ?? $temporaryUploadedFile->getClientOriginalName())[0];
        $storageId = $temporaryUploadedFile->storeAs(
            path: $storagePath,
            name: $documentFileName,
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
