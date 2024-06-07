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
                            <td class="justify-items-center cursor-pointer"><img class="max-w-[100px] max-h-[100px]"
                                                                                 src="{{ Storage::disk('s3')->url($image->storage_id) }}"/>
                            </td>
                            <td class="justify-items-center">{{ $image->meta->current_image_name }}</td>
                            <td class="justify-items-center">{{ $image->uploadedBy->email }}</td>
                            <td class="justify-items-center cursor-pointer">
                                <livewire:document-quick-look :$image/>
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

