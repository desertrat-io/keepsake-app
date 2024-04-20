<?php

namespace App\Casts\Images;

use App\DTO\Images\ImageData;
use App\Models\ImageModels\Image;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class ImageDataCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     * @param Model<Image> $model
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return new ImageData(
            id: $attributes['id'],
            uuid: $attributes['uuid'],
            storageId: $attributes['storage_id'],
            storagePath: $attributes['storage_path'],
            uploadedBy: $attributes['uploaded_by'],
            isLocked: $attributes['is_locked'],
            isDirty: $attributes['is_dirty'],
            createdAt: $attributes['created_at'],
            updatedAt: $attributes['updated_at'],
            deletedAt: $attributes['deleted_at'],
            isDeleted: $attributes['is_deleted']
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     * @param Model<Image> $model
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!$value instanceof ImageData) {
            throw new InvalidArgumentException('Value is not an instance of ImageData');
        }
        return [
            'storage_id' => $value->storageId,
            'storage_path' => $value->storagePath,
            'is_locked' => $value->isLocked,
            'is_dirty' => $value->isDirty,
            'deleted_at' => $value->deletedAt,
            'updated_at' => $value->updatedAt
        ];
    }
}
