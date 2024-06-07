<?php

namespace App\Http\Livewire;

use App\Models\ImageModels\Image;
use Livewire\Component;

class DocumentQuickLook extends Component
{

    public Image $image;

    public function render()
    {
        return view('livewire.document-quick-look');
    }
}
