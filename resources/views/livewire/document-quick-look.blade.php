<div class="bg-[#C3B3A9] rounded-lg shadow-lg w-full h-full relative">
    <div class="flex flex-row">

        <div class="shrink-0 mr-4">
            <img class="max-w-[50%] max-h-[50%] absolute left-5 top-5"
                 src="{{ Storage::disk('s3')->url($image->storage_path . '/' . $image->meta->current_image_name . '.' . $image->meta->original_file_ext) }}"/>
            <div class="absolute right-[30%] mt-10">
                <strong>{{ __('keepsake.image_detail.current_title') }}:</strong>
                <p>{{ $image->meta->current_image_name }}</p>
                <br>
                <strong>{{ __('keepsake.image_detail.original_title') }}:</strong>
                <p>{{ $image->meta->original_image_name }}</p>
                <br>
                <strong>{{ __('keepsake.image_detail.current_filesize') }}:</strong>
                <p>{{ $image->meta->current_filesize }}</p>
                <br>
                <strong>{{ __('keepsake.image_detail.original_filesize') }}:</strong>
                <p>{{ $image->meta->original_filesize }}</p>
                <br>
                <strong>{{ __('keepsake.image_detail.uploaded_by') }}:</strong>
                <p>{{ $image->uploadedBy->name }} &lt;{{ $image->uploadedBy->email }}&gt;</p>
                <br>
                <strong>{{ __('keepsake.image_detail.dirty.dirty_state') }}:</strong>
                <p>{{ !$image->is_dirty ? __('keepsake.image_detail.dirty.is_not_dirty') : __('keepsake.image_detail.dirty.is_dirty') }}</p>
            </div>
        </div>
    </div>

</div>
