<?php

namespace App\Http\Livewire;

use App\Services\ServiceContracts\ImageServiceContract;
use Livewire\Attributes\On;
use Livewire\Component;


class BookmarkDialog extends Component
{
    public bool $isBookmarkDialogOpen = false;

    public string $bookmarkLabel = '';

    private ImageServiceContract $imageService;

    public ?string $imageId = null;

    public function boot(ImageServiceContract $imageService): void
    {
        $this->imageService = $imageService;
    }

    #[On('edit-bookmark')]
    public function openEditBookmarkDialog(array $selectedThumbnail): void
    {
        $this->isBookmarkDialogOpen = true;
        $this->imageId = $selectedThumbnail['uuid'] ?? null;
        $this->bookmarkLabel = $this->imageService->getBookmarkLabel($this->imageId);
    }

    public function closeBookmarkDialog(): void
    {
        $this->isBookmarkDialogOpen = false;
    }

    public function saveLabel(): void
    {
        $this->isBookmarkDialogOpen = false;
        $this->imageService->upsertBookmarkForImage($this->bookmarkLabel, $this->imageId)->image->uuid;
    }

    public function render()
    {
        return view('livewire.bookmark-dialog');
    }
}
