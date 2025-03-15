<?php

namespace Tests\Unit\DTO\Accounts;

use App\DTO\Accounts\AccountData;
use App\Models\AccountModels\Account;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(AccountData::class)]
class AccountDataTest extends TestCase
{

    #[Test]
    public function canCreateFromAccountModel(): void
    {
        $account = Account::factory()->create();
        $accountData = AccountData::fromModel($account);
        $this->assertEquals($account->id, $accountData->id);
        $this->assertEquals($account->mfa_enabled, $accountData->isMfaEnabled);
        $this->assertEquals($account->user->id, $accountData->user->id);
    }
}
