<?php

namespace App\Services\DocumentServices;

use App\DTO\Documents\DocumentData;
use App\DTO\Images\ImageData;
use App\Repositories\KeepsakeEloquentRepository;
use App\Repositories\RepositoryContracts\DocumentRepositoryContract;
use App\Services\KeepsakeService;
use App\Services\ServiceContracts\DocumentConverterServiceContract;
use Illuminate\Support\Collection;
use Log;

class DocumentConverterService implements DocumentConverterServiceContract, KeepsakeService
{
    public function __construct(private DocumentRepositoryContract $documentRepository)
    {
    }

    /**
     * @param DocumentData $documentData
     * @return Collection<ImageData>
     */
    public function convertViaGrpcService(DocumentData $documentData): Collection
    {
        if ($this->documentRepository instanceof KeepsakeEloquentRepository) {
            Log::info('What is the model we\'re writing to?');
            Log::info($this->documentRepository->concreteEntityClass());
        }
        return collect();
    }
}
