<?php

namespace Tests\Unit\DTO\Images;

use App\DTO\Images\ImageMetaData;
use App\Models\AccountModels\User;
use App\Models\ImageModels\Image;
use App\Models\ImageModels\ImageMeta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ImageMetaData::class)]
class ImageMetaDataTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function canCreateFromImageMetaModel(): void
    {
        $imageMeta = ImageMeta::factory()
            ->for(Image::factory()->has(User::factory(), 'uploadedBy')->create())->create();
        $imageMetaData = ImageMetaData::fromModel($imageMeta);
        $this->assertEquals($imageMeta->id, $imageMetaData->id);
        $image = $imageMetaData->image;
        $this->assertEquals($imageMeta->image->id, $image->id);
        $this->assertEquals($imageMeta->image->uploadedBy->id, $image->uploadedBy->id);
        $this->assertInstanceOf(Image::class, $imageMeta->image);
    }
}
