<?php

namespace Database\Factories\ImageModels;

use App\Models\ImageModels\Image;
use App\Models\ImageModels\ImageMeta;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class ImageMetaFactory extends Factory
{

    protected $model = ImageMeta::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_id' => Image::factory()->create()->id,
            'original_image_name' => fake()->randomLetter,
            'current_image_name' => fake()->randomLetter,
            'original_image_mime' => 'image/jpeg',
            'original_filesize' => fake()->numberBetween(),
            'current_filesize' => fake()->numberBetween(),
            'original_file_ext' => fake()->fileExtension()
        ];
    }
}
