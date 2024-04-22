<?php

namespace App\Http\Livewire;

use App\Services\ServiceContracts\ImageServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rules\File;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class UploadNewDocument extends Component
{
    use WithFileUploads;

    /**
     * You can't type this field before upload, so we'll use old school annotations
     * @var TemporaryUploadedFile
     */
    #[Validate('image')]
    public $image;
    public bool $isUploaded = false;

    private ImageServiceContract $imageService;

    public function boot(ImageServiceContract $imageService): void
    {
        $this->imageService = $imageService;
    }

    public function updatedImage(string $propertyName)
    {
        if ($propertyName === 'image') {
            $this->validateOnly($propertyName, [
                File::types(['jpg', 'pdf', 'jpeg', 'png', 'bmp'])
                    ->min(config('keepsake.min_image_size'))
            ]);
        } else {
            $this->validateOnly($propertyName);
        }
    }

    public function render(): View
    {
        return view('livewire.upload-new-document');
    }

    public function saveImage(): void
    {
        $this->validate([
            'image' => [
                File::types(['jpg', 'pdf', 'jpeg', 'png', 'bmp'])
                    ->min(config('keepsake.min_image_size'))
            ]
        ]);
        $imageData = $this->imageService->saveImage($this->image);
        $this->image = null;
        $this->isUploaded = true;
        $this->dispatch('doc-uploaded', imageData: $imageData);
    }
}
