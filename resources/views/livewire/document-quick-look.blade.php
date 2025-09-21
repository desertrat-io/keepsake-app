<div class="bg-[#C3B3A9] rounded-lg shadow-lg w-full h-full relative">
    <div class="flex flex-row">

        <div class="shrink-0 mr-4">
            @if($image->is_dirty)
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     class="max-w-[50%] max-h-[50%] absolute left-5 top-5">
                    <path
                        d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z"/>
                    <path
                        d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/>
                </svg>

            @else
                <img class="max-w-[90%] max-h-[90%] absolute left-5 top-5"
                     src="{{ Storage::disk(Keepsake::getCurrentDiskName())->url($image->storage_path . '/' . $image->meta->current_image_name . '.' . $image->meta->original_file_ext) }}"/>
            @endif
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
