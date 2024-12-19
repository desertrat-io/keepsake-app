<?php

namespace App\Http\Livewire;

use App\Events\ImageViewed;
use App\Models\ImageModels\Image;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class DocumentQuickLook extends Component
{

    public Image $image;

    public function render()
    {
        event(new ImageViewed(userId: Auth::id(), eventTime: now(), imageId: $this->image->id));
        return view('livewire.document-quick-look');
    }
}
