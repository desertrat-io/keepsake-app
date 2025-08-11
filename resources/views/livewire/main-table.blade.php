<div class="m-auto flex justify-end relative">
    @if(count($images) > 0)
        <div class="w-[40%] mr-10 mt-5">
            <div class="overflow-auto h-[500px]">
                <table class="w-full">
                    <thead class="justify-between">
                    <tr class="sticky top-0 bg-white">
                        <th>{{ __('keepsake.pages.main.document_list_thumb') }}</th>
                        <th>{{ __('keepsake.pages.main.document_list_name') }}</th>
                        <th>{{ __('keepsake.pages.main.document_list_user') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($images as $image)
                        <tr wire:key="{{ Keepsake::idToKey($image->uuid) }}"
                            class="keepsake__table-row-highlight">
                            <td class="justify-items-center cursor-pointer">
                                @if ($image->is_dirty)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         class="max-w-[100px] max-h-[100px] animate-spin">
                                        <path fill-rule="evenodd"
                                              d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                                              clip-rule="evenodd"/>
                                    </svg>

                                @else
                                    <img class="max-w-[100px] max-h-[100px]"
                                         src="{{ Storage::disk('s3')->url($image->storage_id) }}"/>
                                @endif
                            </td>
                            <td class="justify-items-center">{{ $image->meta?->current_image_name }}</td>
                            <td class="justify-items-center">{{ $image->uploadedBy?->email }}</td>
                            <td class="justify-items-center cursor-pointer">
                                <div x-data="{isOpen: false}">
                                    <div tabindex=0 class="text-xs"
                                         @click="isOpen = true">{{ __('keepsake.button.quick_look') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-4 h-4 mb-3"
                                             viewBox="0 0 512 512">
                                            <path
                                                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                                        </svg>
                                    </div>
                                    <div x-show="isOpen"
                                         class="modal fixed inset-0 flex items-center justify-center z-50 m-auto w-[80%] h-[80%]">
                                        <livewire:document-quick-look :$image
                                                                      wire:key="{{ Keepsake::idToKey($image->uuid) }}-quick-look"/>
                                        <button @click="isOpen = false"
                                                class="keepsake__cancel-gray-btn absolute bottom-0 right-0 m-10">
                                            {{ __('keepsake.button.close') }}
                                        </button>
                                    </div>
                                </div>
                                <div tabindex=0 class="text-xs">{{ __('keepsake.button.full_record') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-4 h-4"
                                         viewBox="0 0 576 512">
                                        <path
                                            d="M0 80v48c0 17.7 14.3 32 32 32H48 96V80c0-26.5-21.5-48-48-48S0 53.5 0 80zM112 32c10 13.4 16 30 16 48V384c0 35.3 28.7 64 64 64s64-28.7 64-64v-5.3c0-32.4 26.3-58.7 58.7-58.7H480V128c0-53-43-96-96-96H112zM464 480c61.9 0 112-50.1 112-112c0-8.8-7.2-16-16-16H314.7c-14.7 0-26.7 11.9-26.7 26.7V384c0 53-43 96-96 96H368h96z"/>
                                    </svg>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $images->links() }}
        </div>

    @endif
</div>

