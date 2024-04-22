<div>
    <table>
        <thead>
        <th>{{ __('keepsake.pages.main.document_list_thumb') }}</th>
        <th>{{ __('keepsake.pages.main.document_list_name') }}</th>
        </thead>
        <tbody>

        @foreach($images as $image)
            <tr>
                <td><img src="{{ Storage::disk('s3')->url($image->storage_id) }}"/></td>
                <td>{{ $image->meta->current_image_name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        {{ $images->links() }}
    </div>
</div>
