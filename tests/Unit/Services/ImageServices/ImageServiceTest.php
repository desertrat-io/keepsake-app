<?php

namespace Tests\Unit\Services\ImageServices;

use App\DTO\Accounts\UserData;
use App\DTO\Images\ImageData;
use App\Events\ImageUploaded;
use App\Models\AccountModels\User;
use App\Models\ImageModels\Image;
use App\Repositories\RepositoryContracts\ImageMetaRepositoryContract;
use App\Repositories\RepositoryContracts\ImageRepositoryContract;
use App\Repositories\RepositoryContracts\UserRepositoryContract;
use App\Services\ImageServices\ImageService;
use App\Services\ServiceContracts\ImageServiceContract;
use Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Keepsake;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Storage;
use Tests\TestCase;

#[CoversClass(ImageService::class)]
class ImageServiceTest extends TestCase
{
    use RefreshDatabase;

    private ImageServiceContract $imageService;
    private $userRepoMock;
    private $imageRepoMock;

    private $user;

    private $image;

    private $storageId;

    private $storagePath;

    private $fakeImage;

    #[Test]
    public function canCreateImage(): void
    {
        Event::fake();
        $resultingImageData = $this->imageService->saveImage($this->fakeImage, 'fake_title');
        Event::assertDispatched(function (ImageUploaded $event) use ($resultingImageData) {
            return $event->imageData->storageId === $resultingImageData->storageId;
        });
        $this->assertEquals($this->image->storage_id, $resultingImageData->storageId);

    }

    #[Test]
    public function canGetPagedImages(): void
    {
        $images = $this->imageService->getImages();
        $this->assertTrue($images->isNotEmpty());
        $this->assertCount(1, $images);
        $this->assertInstanceOf(Image::class, $images[0]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('testing');
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->fakeImage = TemporaryUploadedFile::fake()->image('fake-image.jpg');
        $this->storageId = fake()->uuid;
        $this->storagePath = Keepsake::getNewStoragePath();
        $this->image = Image::factory()->create(['uploaded_by' => $this->user->id, 'storage_id' => $this->storageId, 'storage_path' => $this->storagePath]);
        $this->imageMetaMock = $this->mock(ImageMetaRepositoryContract::class, function (MockInterface $mock) {
            $mock->shouldReceive('createImageMeta');
        });

        $this->userRepoMock = $this->mock(UserRepositoryContract::class, function (MockInterface $mock) {
            $mock->shouldReceive('getUserById')->with($this->user->id, false, true)->andReturn(UserData::fromModel($this->user));
        });

        $this->imageRepoMock = $this->mock(
            ImageRepositoryContract::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('createImage')
                    ->andReturn(ImageData::fromModel($this->image));
                $mock->shouldReceive('getImages')->andReturn(Image::cursorPaginate(10));
            }
        );
        $this->imageService = $this->app->makeWith(
            ImageServiceContract::class,
            ['imageRepository' => $this->imageRepoMock, 'imageMetaRepository' => $this->imageMetaMock, 'userRepository' => $this->userRepoMock]
        );

    }
}
