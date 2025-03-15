<?php

namespace Tests\Unit\DTO\Accounts;

use App\DTO\Accounts\UserData;
use App\Models\AccountModels\Account;
use App\Models\AccountModels\User;
use App\Models\DocumentModels\Document;
use App\Models\ImageModels\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(UserData::class)]
class UserDataTest extends TestCase
{

    use RefreshDatabase;

    #[Test]
    public function canCreateFromModel(): void
    {
        $user = User::factory()->create();
        $account = Account::factory()->create(['user_id' => $user->id]);
        Document::factory()->count(3)->create(['uploaded_by' => $user->id]);
        Image::factory()->count(5)->create(['uploaded_by' => $user->id]);
        $userData = UserData::fromModel($user);
        $this->assertEquals($user->id, $userData->id);
        $this->assertEquals($account->id, $userData->account->id);
        $imageDataCollection = $userData->images; // it's lazy loaded so force a resolution
        $documentDataCollection = $userData->documents;
        $this->assertCount(5, $imageDataCollection->toArray());
        $this->assertCount(3, $documentDataCollection->toArray());
    }
}
