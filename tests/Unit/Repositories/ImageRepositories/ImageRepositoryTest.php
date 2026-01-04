<?php

namespace Tests\Unit\Repositories\ImageRepositories;

use App\DTO\Accounts\UserData;
use App\DTO\Images\ImageData;
use App\Exceptions\KeepsakeExceptions\KeepsakeDatabaseException;
use App\Exceptions\KeepsakeExceptions\KeepsakeMissingFileException;
use App\Models\AccountModels\User;
use App\Models\ImageModels\Image;
use App\Repositories\ImageRepositories\ImageEloquentRepository;
use App\Repositories\RepositoryContracts\ImageRepositoryContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Ramsey\Uuid\Uuid;
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

    #[Test]
    public function canMarkImageAsProcessed(): void
    {
        $image = Image::factory()->create(['is_dirty' => true]);
        $this->imageRepository->markProcessed($image->storage_id);
        $this->assertDatabaseHas('images', [
            'id' => $image->id,
            'is_dirty' => false,
        ]);
    }

    #[Test]
    public function checkIfImageMissing(): void
    {
        $this->expectException(KeepsakeDatabaseException::class);
        $this->imageRepository->markProcessed('non-existent-storage-id');
    }

    #[Test]
    public function canGetImageByUUID(): void
    {
        $image = Image::factory()->create();
        $result = $this->imageRepository->getImageByUUID($image->uuid);
        $this->assertInstanceOf(ImageData::class, $result);
        $this->assertEquals($image->uuid, $result->uuid);
    }

    #[Test]
    public function getImageByUUIDAndCheckDTO(): void
    {
        $result = $this->imageRepository->getImageByUUID('');
        $this->assertInstanceOf(ImageData::class, $result);
        $this->assertNull($result->uuid);
    }

    #[Test]
    public function notFoundExceptionWorks(): void
    {
        $this->expectException(KeepsakeMissingFileException::class);
        $this->imageRepository->getImageByUUID(Uuid::uuid4()->toString());
    }

    #[Test]
    public function getsImageByID(): void
    {
        $image = Image::factory()->create();
        $result = $this->imageRepository->getImageByID($image->id);
        // remember we don't return the actual model, just the DTO representation
        // since this is an eloquent based repository we want to avoid returning
        // model instances, however this may change
        $this->assertInstanceOf(ImageData::class, $result);
        $this->assertEquals($image->id, $result->id);
    }

    #[Test]
    public function imageNotFound(): void
    {
        $this->expectException(KeepsakeMissingFileException::class);
        $this->imageRepository->getImageByID(-1);
    }
}
