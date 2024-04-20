<div>
    <div x-data="{ isOpen: false, uploading: false, progress: 0 }">
        <button @click="isOpen = true; $wire.isUploaded = false" class="keepsake__action-green-btn">
            {{ __('keepsake.button.add_document') }}

        </button>
        <div x-show="$wire.isUploaded">fwejfpewifjeowfij</div>

        <div x-show="isOpen && !$wire.isUploaded"
             x-on:livewire-upload-start="uploading = true"
             x-on:livewire-upload-finish="uploading = false"
             x-on:livewire-upload-cancel="uploading = false"
             x-on:livewire-upload-error="uploading = false"
             x-on:livewire-upload-progress="progress = $event.detail.progress"
             class="fixed inset-0 flex items-center justify-center">
            <div class="bg-[#C3B3A9] p-6 rounded-lg shadow-lg w-[600px]">
                <h2 class="text-lg font-bold mb-4">{{ __('keepsake.title.add_document_modal_title') }}</h2>
                <form wire:submit="saveImage" class="w-[500px] h-[200px]">

                    <label for="esd__add-doc-input" class="hover:cursor-pointer"
                           id="esd__add-doc-input-label">{{ __('keepsake.field_label.modal_add_document') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6 inline">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                        </svg>
                    </label>
                    <br>
                    @if ($image)

                        <img class="w-24 h-24 m-1" src="{{ $image->temporaryUrl() }}">

                    @endif
                    <input type="file" id="esd__add-doc-input" wire:model.live="image"
                           aria-labelledby="esd__add-doc-input-label"
                           class="z-[-1] hidden">
                    <div wire:loading wire:target="image">{{ __('keepsake.field_label.modal_add_loading') }}</div>
                    @error('image') <p class="esd__form-text-error">{{ $message  }}</p> @enderror
                    @if($image)
                        <div x-show="uploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                        <button type="submit"
                                class="esd__action-green-btn">{{ __('keepsake.field_label.modal_save_uploaded') }}</button>
                    @endif
                </form>
                <br>
                <button @click="isOpen = false"
                        class="esd__cancel-gray-btn float-end">
                    {{ __('keepsake.button.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
