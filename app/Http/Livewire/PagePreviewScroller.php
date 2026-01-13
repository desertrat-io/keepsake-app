<?php

namespace App\Http\Livewire;

use App\DTO\Images\ImageData;
use App\Services\ServiceContracts\DocumentServiceContract;
use App\Services\ServiceContracts\ImageServiceContract;
use Crypt;
use Livewire\Component;
use Spatie\LaravelData\DataCollection;

class PagePreviewScroller extends Component
{
    public $imageId;

    public $documentId;

    /** @var DataCollection<ImageData> */
    public $thumbnails;

    public $selectedThumbnail;

    private ImageServiceContract $imageService;

    private DocumentServiceContract $documentService;

    public function boot(ImageServiceContract $imageService, DocumentServiceContract $documentService): void
    {
        $this->imageService = $imageService;
        $this->documentService = $documentService;
    }

    public function mount(): void
    {
        $this->loadThumbnails();
    }

    /**
     * Let's use the thumbnails instance variable as a cache?
     */
    public function loadThumbnails(): DataCollection|array
    {
        if (!$this->documentId) {
            // i don't like doing things this way but I'm going to chance the AI here
            // sets the value of thumbnails and returns it at the same time
            return $this->thumbnails = [];
        }
        $this->thumbnails = ImageData::collect(
            $this->documentService->getDocumentThumbnails($this->documentId)->toArray(),
        );
        return $this->thumbnails;
    }

    public function openEditBookmark(string $selectedThumbnailEncrypted): void
    {
        $selectedThumbnail = ImageData::from(json_decode(Crypt::decryptString($selectedThumbnailEncrypted)));
        $this->dispatch('edit-bookmark', selectedThumbnail: $selectedThumbnail);
    }

    public function render()
    {
        // need to pre-seed to force an update I believe, unless Liveware has changed something?
        $thumbnails = $this->thumbnails ?? $this->loadThumbnails();
        return view('livewire.page-preview-scroller', ['thumbnails' => $thumbnails]);
    }
}
