<div class="m-auto flex justify-end relative">
    <div class="w-[30%] mr-10 mt-5">
        <div class="overflow-auto h-[500px]">
            <table class="w-full">
                <thead class="justify-between">
                <tr class="sticky top-0 bg-white">
                    <th>{{ __('keepsake.pages.main.document_list_thumb') }}</th>
                    <th>{{ __('keepsake.pages.main.document_list_name') }}</th>
                    <th>{{ __('keepsake.pages.main.document_list_user') }}</th>
                </tr>
                </thead>
                <tbody>

                @foreach($images as $image)
                    <tr wire:key="keepsake-doc-{{ $image->uuid }}" class="keepsake__table-row-highlight">
                        <td class="justify-items-center cursor-pointer"><img class="max-w-[100px] max-h-[100px]"
                                                                             src="{{ Storage::disk('s3')->url($image->storage_id) }}"/>
                        </td>
                        <td class="justify-items-center">{{ $image->meta->current_image_name }}</td>
                        <td class="justify-items-center">{{ $image->uploadedBy->email }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $images->links() }}
    </div>


</div>

