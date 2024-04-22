<?php

namespace App\Http\Livewire;

use App\Services\ServiceContracts\ImageServiceContract;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class MainTable extends Component
{
    use WithPagination;

    private const int PER_PAGE = 2;

    public $cursor;

    // livewire really doesn't like poagination
    private $images;
    public int $perPage = 10;

    private ImageServiceContract $imageService;

    public function boot(ImageServiceContract $imageService): void
    {
        $this->imageService = $imageService;
    }

    #[On('doc-uploaded')]
    public function updateImageList($imageData)
    {
        $this->images = $this->imageService->getImages(perPage: self::PER_PAGE);
    }

    public function render()
    {
        $this->images = $this->imageService->getImages(perPage: self::PER_PAGE);

        return view(
            'livewire.main-table',
            ['images' => $this->images]
        );
    }
}
