<?php

namespace App\Http\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class PdfViewer extends Component
{

    public $documentPath;

    public $selectedPageNum;

    #[On('set-pdf-page-number')]
    public function setPage(int $pageNum): void
    {
        $this->selectedPageNum = $pageNum;
        $this->dispatch('refresh-viewer-page', pageNum: $this->selectedPageNum)->self();
    }

    public function render()
    {
        return view('livewire.pdf-viewer');
    }
}
