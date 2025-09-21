<?php

namespace App\Http\Livewire;

use App\Services\ServiceContracts\DocumentServiceContract;
use App\Services\ServiceContracts\ImageServiceContract;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Log;

class MainTable extends Component
{
    use WithPagination;

    public const string PAGE_NAME = 'main_table_page';
    public $cursor;

    // livewire really doesn't like pagination
    public int $perPage = 10;
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

    public function updateImageList(): void
    {
        $this->images = $this->imageService->getImages(perPage: $this->perPage, pageName: static::PAGE_NAME);
        Log::info('updating image list');
        $this->setPage(page: 1, pageName: static::PAGE_NAME);
    }

    public function updateProcessingList($documentData): void
    {
        Log::info('updating processing list');
    }

    public function pdfConverted(Collection $images): void
    {
        Log::info('pdf converted');
    }

    public function render()
    {
        $this->images = $this->imageService->getImages(perPage: $this->perPage, pageName: static::PAGE_NAME);

        return view(
            'livewire.main-table',
            ['images' => $this->images]
        );
    }
}
