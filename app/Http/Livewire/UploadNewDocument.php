<?php

namespace App\Http\Livewire;

use App\Services\ServiceContracts\DocumentServiceContract;
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

    private const array ALLOWED_FILE_TYPES = ['jpg', 'pdf', 'jpeg', 'png', 'bmp'];
    /**
     * You can't type this field before upload, so we'll use old school annotations
     * @var TemporaryUploadedFile
     */
    #[Validate(['file', 'extensions:jpg, pdf, jpeg, png, bmp'])]
    public $image;
    public bool $isUploaded = false;

    #[Validate('required')]
    public string $imageTitle = '';

    private ImageServiceContract $imageService;

    private DocumentServiceContract $documentService;

    public function boot(ImageServiceContract $imageService, DocumentServiceContract $documentService): void
    {
        $this->imageService = $imageService;
        $this->documentService = $documentService;
    }

    public function updatedImage(string $propertyName)
    {
        if ($propertyName === 'image') {
            $this->validateOnly($propertyName, [
                File::types(self::ALLOWED_FILE_TYPES)
                    ->min(config('keepsake.min_image_size'))
            ]);
        } else {
            $this->validateOnly($propertyName);
        }
        $this->imageTitle = $this->image?->getClientOriginalName();
    }

    public function render(): View
    {
        return view('livewire.upload-new-document');
    }

    public function saveImage(): void
    {
        $this->validate([
            'image' => [
                File::types(self::ALLOWED_FILE_TYPES)
                    ->min(config('keepsake.min_image_size'))
            ]
        ]);
        if ($this->imageTitle !== '') {
            if ($this->image->getClientOriginalExtension() !== 'pdf') {
                $imageData = $this->imageService->saveImage(
                    uploadedFile: $this->image,
                    customTitle: $this->imageTitle
                );
            } else {
                $imageData = $this->documentService->createDocument(temporaryUploadedFile: $this->image, customTitle: $this->imageTitle);
            }
            $this->dispatch('doc-uploaded-custom-title');
        } else {
            // TODO: refactor the custom title handler
            if ($this->image->getClientOriginalExtension() !== 'pdf') {
                $imageData = $this->documentService->createDocument(temporaryUploadedFile: $this->image);
            } else {
                $imageData = $this->imageService->saveImage(uploadedFile: $this->image);
            }
        }
        $this->image = null;
        $this->isUploaded = true;
        $this->dispatch('doc-uploaded', imageData: $imageData);
    }
}
