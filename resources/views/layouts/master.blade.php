<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Keepsake' }}</title>
    @includeUnless(Auth::check(), 'layouts.public.head')
    @auth
        @include('layouts.private.head')
    @endauth

    @livewireStyles
</head>
<body class="h-auto keepsake__layout-bg">
<div id="keepsake__app" class="w-auto relative">
    @includeUnless(Auth::check(), 'layouts.public.masthead')
    @auth
        <div id="keepsake__masthead">
            @include('layouts.private.masthead')
        </div>
    @endauth
    @yield('content')
    @includeUnless(Auth::check(), 'layouts.public.footer')
    @auth
        {{-- @include('layouts.private.footer') --}}
    @endauth
</div>
@livewireScriptConfig
@yield('extra_scripts')
</body>
</html>
