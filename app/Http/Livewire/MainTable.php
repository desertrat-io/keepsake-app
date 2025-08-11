<?php

namespace App\Http\Livewire;

use App\Services\ServiceContracts\DocumentServiceContract;
use App\Services\ServiceContracts\ImageServiceContract;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class MainTable extends Component
{
    use WithPagination;

    public $cursor;

    // livewire really doesn't like pagination
    public int $perPage = 10;
    protected $listeners = ['pdf-converted'];
    /**
     * @var CursorPaginator
     */
    private $images;
    private ImageServiceContract $imageService;

    private DocumentServiceContract $documentService;

    public function boot(ImageServiceContract $imageService, DocumentServiceContract $documentService): void
    {
        $this->imageService = $imageService;
        $this->documentService = $documentService;
    }

    #[On('doc-uploaded')]
    public function updateImageList($imageData): void
    {
        $this->images = $this->imageService->getImages(perPage: $this->perPage);
    }

    #[On('pdf-uploaded')]
    public function updateProcessingList($documentData): void
    {

    }

    public function pdfConverted(Collection $images): void
    {

    }

    public function render()
    {
        $this->images = $this->imageService->getImages(perPage: $this->perPage, pageName: 'main_table_page');

        return view(
            'livewire.main-table',
            ['images' => $this->images]
        );
    }
}
