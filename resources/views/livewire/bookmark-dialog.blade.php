<div x-data="{saving: false}">
    <div x-show="$wire.isBookmarkDialogOpen"
         class="keepsake__modal-default">
        <div class="absolute right-0 mr-10 mt-auto mb-auto h-50">
            <div class="bg-[#C3B3A9] p-6 relative rounded-lg shadow-lg w-[80%] h-[80%]">
                <label for="keepsake__bookmark-label">{{ __('keepsake.field_label.modal_bookmark_label') }}</label>
                <input type="text" id="keepsake__bookmark-label" class="w-full" name="keepsake__bookmark-label"
                       x-model="$wire.bookmarkLabel">
                <div class=" absolute bottom-0 right-0 mr-5 mb-5">

                    <button @click="$wire.isBookmarkDialogOpen = false"
                            class="keepsake__cancel-gray-btn">
                        {{ __('keepsake.button.close') }}
                    </button>
                    <button @click="$wire.saveLabel()" class="keepsake__action-green-btn">
                        {{ __('keepsake.button.save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
