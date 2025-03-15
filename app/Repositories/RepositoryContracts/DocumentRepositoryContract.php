<?php

namespace App\Repositories\RepositoryContracts;

use App\DTO\Documents\DocumentData;

interface DocumentRepositoryContract
{

    public function createDocument(DocumentData $documentData): DocumentData;
}
