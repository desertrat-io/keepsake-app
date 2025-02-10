<?php

namespace Database\Factories\ImageModels;

use App\Models\AccountModels\User;
use App\Models\ImageModels\Image;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class ImageFactory extends Factory
{

    protected $model = Image::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'storage_id' => fake()->uuid,
            'storage_path' => fake()->filePath(),
            'is_locked' => false,
            'is_dirty' => true,
            'uploaded_by' => User::factory()->create()->id
        ];
    }
}
