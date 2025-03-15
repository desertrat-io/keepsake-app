<?php

namespace Database\Factories\DocumentModels;

use App\Models\AccountModels\User;
use App\Models\DocumentModels\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{

    protected $model = Document::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'num_pages' => $this->faker->randomDigit(),
            'uploaded_by' => User::factory()->create()->id,
            'storage_id' => $this->faker->uuid
        ];
    }

}
