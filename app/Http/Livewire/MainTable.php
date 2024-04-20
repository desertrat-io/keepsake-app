<?php

namespace App\Http\Livewire;

use App\Services\ServiceContracts\ImageServiceContract;
use Livewire\Component;
use Livewire\WithPagination;

class MainTable extends Component
{
    use WithPagination;

    public $cursor;
    public int $perPage = 10;

    private ImageServiceContract $imageService;

    public function boot(ImageServiceContract $imageService): void
    {
        $this->imageService = $imageService;
    }

    public function render()
    {
        $images = $this->imageService->getImages(perPage: 10);

        return view(
            'livewire.main-table',
            ['images' => $images]
        );
    }
}
