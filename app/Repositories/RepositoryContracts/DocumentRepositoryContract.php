<?php

namespace App\Repositories\RepositoryContracts;

use App\DTO\Documents\DocumentData;

interface DocumentRepositoryContract
{

    public function createDocument(DocumentData $documentData): DocumentData;

    public function getDocumentThumbnails(string $documentUUID): DocumentData;

    public function getDocument(string|int $documentId): DocumentData;
}
