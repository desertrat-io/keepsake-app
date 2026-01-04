<?php

namespace App\Repositories\DocumentRepositories;

use App\DTO\Documents\DocumentData;
use App\Models\DocumentModels\Document;
use App\Repositories\KeepsakeEloquentRepository;
use App\Repositories\RepositoryContracts\DocumentRepositoryContract;

class DocumentEloquentRepository implements DocumentRepositoryContract, KeepsakeEloquentRepository
{

    public function concreteEntityClass(): string
    {
        return Document::class;
    }

    public function createDocument(DocumentData $documentData): DocumentData
    {
        return DocumentData::fromModel(Document::create([
            'title' => $documentData->title,
            'uploaded_by' => $documentData->uploadedBy->id,
            'storage_id' => $documentData->storageId,
            'image_id' => $documentData->imageId,
        ])->load('image'));
    }

    public function getDocumentThumbnails(string $documentUUID): DocumentData
    {
        return DocumentData::fromModel(Document::whereUuid($documentUUID)->first()->load('pages'));
    }


}
