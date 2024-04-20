<?php

namespace App\Casts\Images;

use App\DTO\Images\ImageMetaData;
use App\Models\ImageModels\ImageMeta;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class ImageMetaDataCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     * @param Model<ImageMeta> $model
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return new ImageMetaData(
            id: $attributes['id'],
            imageId: $attributes['image_id'],
            originalImageName: $attributes['original_image_name'],
            currentImageName: $attributes['current_image_name'],
            originalImageMime: $attributes['original_image_mime'],
            originalFilesize: $attributes['original_filesize'],
            currentFileSize: $attributes['current_filesize'],
            originalFileExt: $attributes['original_file_ext'],
            createdAt: $attributes['created_at'],
            updatedAt: $attributes['updated_at'],
            deletedAt: $attributes['deleted_at'],
            isDeleted: $attributes['is_deleted'],
            image: $attributes['image']
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     * @param Model<ImageMeta> $model
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!$value instanceof ImageMetaData) {
            throw new InvalidArgumentException('Value is not an instance of ImageMetaData');
        }
        return [
            'image_id' => $value->imageId,
            'image' => $value->image,
            'current_image_name' => $value->currentImageName,
            'current_filesize' => $value->currentFileSize,
            'updated_at' => $value->updatedAt,
            'deleted_at' => $value->deletedAt
        ];
    }
}
