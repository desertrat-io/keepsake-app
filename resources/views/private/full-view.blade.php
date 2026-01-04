@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="inline-block">

            <p>{{ $documentId }}</p>
        </div>
        <div
            {{-- TODO: the image is set to 100% w/h but is constrainted by this container, use this to control total size --}}
            class="col-end-1 absolute right-0 mr-50 w-50 bg-amber-400 h-[80vh] overflow-scroll overscroll-contain">
            <livewire:page-preview-scroller :$documentId/>
        </div>
    </div>

@stop

@section('extra_scripts')
    @vite(['resources/js/pdf.js'])
@stop
