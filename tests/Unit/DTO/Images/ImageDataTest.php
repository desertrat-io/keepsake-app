<?php

namespace Tests\Unit\DTO\Images;

use App\DTO\Images\ImageData;
use App\Models\AccountModels\User;
use App\Models\ImageModels\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ImageData::class)]
class ImageDataTest extends TestCase
{

    use RefreshDatabase;

    #[Test]
    public function canCreateFromImageModel(): void
    {
        $user = User::factory()->create();
        $image = Image::factory()->create(['uploaded_by' => $user->id]);
        $imageData = ImageData::fromModel($image);
        $this->assertEquals($image->id, $imageData->id);
        $this->assertEquals($image->storage_id, $imageData->storageId);
        $this->assertEquals($image->storage_path, $imageData->storagePath);
        // go ahead and resolve the relationship
        $imageDataUploadedBy = $imageData->uploadedBy;
        $this->assertEquals($user->id, $imageDataUploadedBy->id);
    }
}
