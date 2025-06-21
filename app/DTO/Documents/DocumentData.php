<?php

namespace App\DTO\Documents;

use App\DTO\Accounts\UserData;
use App\Models\DocumentModels\Document;
use Carbon\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
final class DocumentData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public readonly ?int               $id,
        public readonly ?string            $uuid,
        public readonly ?string            $title,
        public readonly ?int               $numPages,
        public readonly ?string            $storageId,
        public readonly null|UserData|Lazy $uploadedBy,
        public readonly ?Carbon            $createdAt,
        public readonly ?Carbon            $updatedAt,
        public readonly ?Carbon            $deletedAt,
        public readonly bool               $isDeleted = false
    )
    {
    }

    public static function fromModel(Document $document): self
    {
        return new self(
            id: $document->id,
            uuid: $document->uuid,
            title: $document->title,
            numPages: $document->num_pages,
            storageId: $document->storage_id,
            uploadedBy: Lazy::create(fn() => UserData::fromModel($document->uploadedBy)),
            createdAt: $document->created_at,
            updatedAt: $document->updated_at,
            deletedAt: $document->deleted_at,
            isDeleted: $document->is_deleted,
        );
    }
}
