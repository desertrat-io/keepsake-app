<?php

namespace Tests\Unit\Repositories\ImageRepositories;

use App\DTO\Accounts\UserData;
use App\DTO\Images\ImageData;
use App\Models\AccountModels\User;
use App\Models\ImageModels\Image;
use App\Repositories\ImageRepositories\ImageEloquentRepository;
use App\Repositories\RepositoryContracts\ImageRepositoryContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ImageEloquentRepository::class)]
class ImageRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ImageRepositoryContract $imageRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->imageRepository = $this->app->make(ImageRepositoryContract::class);
    }

    #[Test]
    public function ifEloquentBoundToCorrectConcrete(): void
    {
        if (env('MODEL_MODE') === 'eloquent') {
            $repo = new ImageEloquentRepository();
            $this->assertEquals(Image::class, $repo->concreteEntityClass());
        } else {
            $this->markTestSkipped('Model mode is not eloquent, no need for this test');
        }
    }

    #[Test]
    public function canCreateImageFromImageData(): void
    {
        $user = UserData::fromModel(User::factory()->create());
        $imageData = ImageData::from([
            'storageId' => fake()->shuffleString,
            'storagePath' => fake()->filePath(),
            'uploadedBy' => $user,
            'isDirty' => false
        ]);
        $image = $this->imageRepository->createImage($imageData);
        $this->assertInstanceOf(ImageData::class, $image);
        $this->assertDatabaseHas('images', [
            'storage_id' => $imageData->storageId,
            'storage_path' => $imageData->storagePath,
            'uploaded_by' => $user->id,
        ]);
        $this->assertEquals($user->id, $image->uploadedBy->id);
    }

    #[Test]
    public function canGetSingleImagePath(): void
    {
        $image = Image::factory()->create();
        $path = $this->imageRepository->getImagePaths($image->id);
        $this->assertEquals($path, $image->storage_path);
    }

    #[Test]
    public function canGetMultipleImagePaths(): void
    {
        $images = Image::factory()->count(3)->create();
        $paths = $this->imageRepository->getImagePaths($images->pluck('id')->toArray());
        $this->assertCount(3, $paths);
        $images->each(function ($image) use ($paths) {
            $this->assertTrue(in_array($image->storage_path, $paths->pluck('storage_path')->toArray()));
        });
    }

    #[Test]
    public function getSingleImage(): void
    {
        $image = Image::factory()->create([
            'uploaded_by' => User::factory()->create()->id,
        ]);
        $this->assertDatabaseHas('images', [
            'storage_id' => $image->storage_id,
            'storage_path' => $image->storage_path,
            'uploaded_by' => $image->uploaded_by,
        ]);
        $imagePaginator = $this->imageRepository->getImages();
        $this->assertFalse($imagePaginator->isEmpty());
        $this->assertFalse($imagePaginator->hasPages());
        $this->assertCount(1, $imagePaginator->items());
        $retrievedImageModel = $imagePaginator->items()[0];
        $this->assertInstanceOf(Image::class, $retrievedImageModel);
    }

    #[Test]
    public function canGetMultipleImagesPaged(): void
    {
        Image::factory()->count(20)->create();
        $paginator = $this->imageRepository->getImages(perPage: 5);
        $this->assertTrue($paginator->hasPages());
        $this->assertCount(5, $paginator->items());
    }

    #[Test]
    public function canGetMultipleImagesPagedCursor(): void
    {
        $this->markTestSkipped('Not ready for this yet');
    }
}
