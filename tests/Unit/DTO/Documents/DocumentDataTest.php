<?php

namespace Tests\Unit\DTO\Documents;

use App\DTO\Documents\DocumentData;
use App\Models\AccountModels\User;
use App\Models\DocumentModels\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(DocumentData::class)]
class DocumentDataTest extends TestCase
{

    use RefreshDatabase;

    #[Test]
    public function canCreateFromDocumentModel(): void
    {
        $user = User::factory()->create();
        $document = Document::factory()->create(['uploaded_by' => $user->id]);
        $documentData = DocumentData::fromModel($document);
        $this->assertEquals($document->id, $documentData->id);
        $this->assertEquals($document->title, $documentData->title);
        $userData = $documentData->uploadedBy;
        $this->assertEquals($userData->id, $user->id);
    }
}
