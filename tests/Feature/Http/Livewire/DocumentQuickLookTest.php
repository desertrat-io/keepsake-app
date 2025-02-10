<?php

namespace Tests\Feature\Http\Livewire;

use App\Http\Livewire\DocumentQuickLook;
use App\Models\AccountModels\User;
use App\Models\ImageModels\Image;
use App\Models\ImageModels\ImageMeta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(DocumentQuickLook::class)]
class DocumentQuickLookTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    #[Test]
    public function canRenderQuickLookComponent(): void
    {
        $image = Image::factory()->create([
            'uploaded_by' => $this->user->id,
        ]);
        ImageMeta::factory()->create([
            'image_id' => $image->id,
        ]);
        Livewire::actingAs($this->user)
            ->test(DocumentQuickLook::class)
            ->assertOk();
    }
}
