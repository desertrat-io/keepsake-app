<?php
/*
 * Copyright (c) 2025
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this
 * software and associated documentation files (the "Software"), to deal in the Software
 * without restriction, including without limitation the rights to use, copy, modify, merge,
 *  publish, distribute, sublicense, and/or sell copies of the Software, and to permit
 *  persons to whom the Software is furnished to do so, subject to the following
 *  conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPIRES
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NON INFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
declare(strict_types=1);

namespace Tests\Unit\Repositories\ImageRepositories;

use App\DTO\Images\ImageData;
use App\DTO\Images\ImageMetaData;
use App\Models\AccountModels\User;
use App\Models\ImageModels\Image;
use App\Models\ImageModels\ImageMeta;
use App\Repositories\ImageRepositories\ImageMetaEloquentRepository;
use App\Repositories\RepositoryContracts\ImageMetaRepositoryContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Storage;
use Tests\TestCase;

#[CoversClass(ImageMetaEloquentRepository::class)]
class ImageMetaRepositoryTest extends TestCase
{

    use RefreshDatabase;

    private ImageMetaRepositoryContract $imageMetaRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->imageMetaRepository = $this->app->make(ImageMetaRepositoryContract::class);
    }

    #[Test]
    public function isModelBound(): void
    {
        if (env('MODEL_MODE') === 'eloquent') {
            $repo = new ImageMetaEloquentRepository();
            $this->assertEquals(ImageMeta::class, $repo->concreteEntityClass());
        } else {
            $this->markTestSkipped('Model mode is not eloquent, no need for this test');
        }
    }

    #[Test]
    public function canCreateNewImageMeta(): void
    {
        Storage::fake();
        $uploadedFile = TemporaryUploadedFile::fake()->image('image.jpg');
        $user = User::factory()->create();
        $image = Image::factory()->create([
            'uploaded_by' => $user->id,
        ])->load('uploadedBy');
        $imageData = ImageData::fromModel($image);
        $imageMetaData = ImageMetaData::from([
            'originalImageName' => $uploadedFile->getClientOriginalName(),
            'currentImageName' => 'image.jpg',
            'originalImageMime' => $uploadedFile->getClientMimeType(),
            'originalFilesize' => $uploadedFile->getSize(),
            'currentFilesize' => $uploadedFile->getSize(),
            'originalFileExt' => $uploadedFile->getClientOriginalExtension(),
            'image' => $imageData,
        ]);
        $savedImageMeta = $this->imageMetaRepository->createImageMeta($imageMetaData);
        $this->assertEquals($imageMetaData->originalImageMime, $savedImageMeta->originalImageMime);
        $this->assertEquals($imageMetaData->currentImageName, $savedImageMeta->currentImageName);
        $this->assertDatabaseHas('image_meta', ['id' => $savedImageMeta->id, 'original_image_name' => $savedImageMeta->originalImageName]);
        // resolve the lazy load
        $originalImageId = $imageMetaData->image->id;
        $savedImageId = $savedImageMeta->image->id;
        $this->assertEquals($originalImageId, $savedImageId);

    }


}
