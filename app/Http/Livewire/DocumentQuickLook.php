<?php

namespace App\Http\Livewire;

use App\Events\ImageViewed;
use App\Models\ImageModels\Image;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class DocumentQuickLook extends Component
{

    public Image $image;

    public function render()
    {
        event(new ImageViewed($this->image->uploadedBy->email, now(), $this->image->id));
        return view('livewire.document-quick-look');
    }
}
