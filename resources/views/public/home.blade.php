@extends('layouts.master')
@section('content')

    <div class="flex justify-center items-center">
        @unless(Auth::check())
            <video autoplay muted loop id="keepsake__bg-docs-vid" class="w-full h-full">
                <source src="{{ asset('storage/media/mixkit-inside-an-old-library-24632-medium.mp4') }}"
                        type="video/mp4">
            </video>
            <div class="absolute bg-[#C3B3A9] p-[30px]">
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <label for="esd__email-login" id="esd__email-login-label">Email:</label>
                    <input class="esd__form-text-std bg-[#EFDFD5]" name="email" type="email" id="esd__email-login"
                           aria-labelledby="esd__email-login-label">
                    <br>
                    <label for="esd__password-login" id="esd__password-label">Password:</label>
                    <input class="esd__form-text-std bg-[#EFDFD5]" name="password" type="password"
                           id="esd__password-login"
                           aria-labelledby="esd__password-label">
                    <br>
                    <div class="mt-5 flex justify-between">
                        <button type="reset" class="esd__cancel-gray-btn mr-2">Clear</button>
                        <button type="submit" class="esd__action-green-btn">Login</button>
                    </div>
                </form>
            </div>
        @endunless
    </div>
@stop
