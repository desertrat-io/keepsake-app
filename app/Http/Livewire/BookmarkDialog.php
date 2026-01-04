<?php

namespace App\Http\Livewire;

use App\DTO\Images\ImageData;
use App\Services\ServiceContracts\ImageServiceContract;
use Livewire\Attributes\On;
use Livewire\Component;


class BookmarkDialog extends Component
{
    public bool $isBookmarkDialogOpen = false;

    public string $bookmarkLabel = '';

    private ImageServiceContract $imageService;

    public function boot(ImageServiceContract $imageService): void
    {
        $this->imageService = $imageService;
    }

    #[On('edit-bookmark')]
    public function editBookmarkDialogToggle(array $selectedThumbnail): void
    {
        $this->isBookmarkDialogOpen = !$this->isBookmarkDialogOpen;
        $this->bookmarkLabel = $this->imageService->getBookmarkLabel(ImageData::fromLivewire($selectedThumbnail)->id);
    }

    public function saveLabel(): void
    {
        $this->isBookmarkDialogOpen = false;
    }

    public function render()
    {
        return view('livewire.bookmark-dialog');
    }
}
