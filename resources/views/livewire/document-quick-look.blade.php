<div x-data="{isOpen: false}">
    <div tabindex=0 class="text-xs" @click="isOpen = true">{{ __('keepsake.button.quick_look') }}
        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-4 h-4 mb-3"
             viewBox="0 0 512 512">
            <path
                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
        </svg>
    </div>
    <div x-show="isOpen" class="modal fixed inset-0 flex items-center justify-center z-50 m-auto w-[80%] h-[80%]">
        <div class="bg-[#C3B3A9] rounded-lg shadow-lg w-full h-full relative">
            <div class="flex flex-row">

                <div class="flex-shrink-0 mr-4">
                    <img class="max-w-[80%] max-h-[80%] absolute left-5 top-5"
                         src="{{ Storage::disk('s3')->url($image->storage_path . '/' . $image->meta->current_image_name . '.' . $image->meta->original_file_ext) }}"/>
                </div>
                <div class="absolute right-[50%] mt-10">
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
            <button @click="isOpen = false"
                    class="keepsake__cancel-gray-btn absolute bottom-0 right-0 m-10">
                {{ __('keepsake.button.close') }}
            </button>
        </div>

    </div>
</div>
