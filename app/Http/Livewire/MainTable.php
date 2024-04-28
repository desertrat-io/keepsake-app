<?php

namespace App\Http\Livewire;

use App\Services\ServiceContracts\ImageServiceContract;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class MainTable extends Component
{
    use WithPagination;

    public $cursor;

    // livewire really doesn't like pagination
    private $images;
    public int $perPage = 10;

    private ImageServiceContract $imageService;

    public function boot(ImageServiceContract $imageService): void
    {
        $this->imageService = $imageService;
    }

    #[On('doc-uploaded')]
    public function updateImageList($imageData): void
    {
        $this->images = $this->imageService->getImages(perPage: $this->perPage);
    }

    public function render()
    {
        $this->images = $this->imageService->getImages(perPage: $this->perPage);

        return view(
            'livewire.main-table',
            ['images' => $this->images]
        );
    }
}
