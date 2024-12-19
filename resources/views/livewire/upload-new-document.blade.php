<div>
    <div x-data="{ isOpen: false, uploading: false, progress: 0 }">
        <button @click="isOpen = true; $wire.isUploaded = false" class="keepsake__action-green-btn">
            {{ __('keepsake.button.add_document') }}

        </button>
        <div x-show="isOpen && !$wire.isUploaded"
             x-on:livewire-upload-start="uploading = true"
             x-on:livewire-upload-finish="uploading = false"
             x-on:livewire-upload-cancel="uploading = false"
             x-on:livewire-upload-error="uploading = false"
             x-on:livewire-upload-progress="progress = $event.detail.progress"
             class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-[#C3B3A9] p-6 relative rounded-lg shadow-lg w-[80%] h-[80%]">
                <h2 class="text-lg font-bold mb-4">{{ __('keepsake.title.add_document_modal_title') }}</h2>
                <form wire:submit="saveImage" class="w-[500px] h-[200px]">

                    <label for="keepsake__add-doc-input" class="hover:cursor-pointer"
                           id="keepsake__add-doc-input-label">{{ __('keepsake.field_label.modal_add_document') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6 inline">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                        </svg>
                    </label>
                    <br>
                    @if ($image)

                        @if($image->getClientOriginalExtension() !== 'pdf')
                            <img class="m-1 max-w-[500px] max-h-[500px]" src="{{ $image->temporaryUrl() }}">
                        @endif
                        <div class="absolute right-[25%] top-0 mt-5 mr-5">
                            <label class="" id="keepsake__add-doc-title-label"
                                   aria-label="keepsake_add-doc-title-input">
                                {{ __('keepsake.field_label.modal_doc_title') }}
                            </label>
                            <input class="keepsake__form-text-std" id="keepsake_add-doc-title-input" type="text"
                                   wire:model.live="imageTitle" aria-labelledby="keepsake__add-doc-title-label">
                        </div>

                    @endif
                    <input type="file" id="keepsake__add-doc-input" wire:model.live="image"
                           aria-labelledby="keepsake__add-doc-input-label"
                           class="z-[-1] hidden">
                    <div wire:loading wire:target="image">{{ __('keepsake.field_label.modal_add_loading') }}</div>
                    @error('image') <p class="keepsake__form-text-error">{{ $message  }}</p> @enderror
                    <div x-show="uploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                    @if($image)

                        <button type="submit"
                                class="keepsake__action-green-btn">{{ __('keepsake.field_label.modal_save_uploaded') }}</button>
                    @endif
                </form>
                <br>
                <button @click="isOpen = false"
                        class="keepsake__cancel-gray-btn absolute bottom-0 right-0 m-10">
                    {{ __('keepsake.button.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
