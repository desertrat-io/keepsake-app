<?php

namespace Database\Factories\AccountModels;

use App\Models\AccountModels\Account;
use App\Models\AccountModels\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{

    protected $model = Account::class;
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'is_locked' => false,
            'mfa_enabled' => false
        ];
    }
}
