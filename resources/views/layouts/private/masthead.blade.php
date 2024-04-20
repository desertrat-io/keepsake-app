<div class="container-fluid relative h-[75px] keepsake__bg-brown">
    <form id="keepsake__logout-form" method="post" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
    <div id="keepsake__upload-document-action" class="absolute right-0 mr-10 mt-auto mb-auto">
        <livewire:upload-new-document/>
    </div>
</div>
