<div class="container-fluid relative h-[75px] keepsake__bg-brown pt-5">
    <form id="keepsake__logout-form" method="post" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="keepsake__cancel-gray-btn absolute left-0 ml-10 mt-auto mb-auto">Logout</button>
    </form>
    <div id="keepsake__upload-document-action" class="absolute right-0 mr-10 mt-auto mb-auto">
        <livewire:upload-new-document/>
    </div>
</div>
