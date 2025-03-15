@extends('layouts.master')
@section('content')

    <div class="flex justify-center items-center">
        @unless(Auth::check())
            <video autoplay muted loop id="keepsake__bg-docs-vid" class="w-full h-full">
                <source src="{{ asset('media/mixkit-inside-an-old-library-24632-hd-ready.mp4') }}"
                        type="video/mp4">
            </video>
            <div class="absolute bg-[#C3B3A9] p-[30px]">
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <label for="keepsake__email-login" id="keepsake__email-login-label">Email:</label>
                    <input class="keepsake__form-text-std bg-[#EFDFD5]" name="email" type="email" id="keepsake__email-login"
                           aria-labelledby="keepsake__email-login-label">
                    <br>
                    <label for="keepsake__password-login" id="keepsake__password-label">Password:</label>
                    <input class="keepsake__form-text-std bg-[#EFDFD5]" name="password" type="password"
                           id="keepsake__password-login"
                           aria-labelledby="keepsake__password-label">
                    <br>
                    <div class="mt-5 flex justify-between">
                        <button type="reset" class="keepsake__cancel-gray-btn mr-2">Clear</button>
                        <button type="submit" class="keepsake__action-green-btn">Login</button>
                    </div>
                </form>
            </div>
        @endunless
    </div>
@stop
