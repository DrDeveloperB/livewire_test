<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    {{--    livewire 태그 : laravel 7 부터 지원--}}
    <livewire:styles>
{{--    @livewireStyles--}}
</head>

<body>

<div class="flex flex-wrap justify-center">

    <div class="flex w-full justify-between px-4 bg-purple-900 text-white">
        <a class="mx-3 py-4" href="/home">Home</a>
        @auth
            <livewire:logout />
        @endauth
        @guest
            <div class="py-4">
                <a class="mx-3" href="/loginw">Login</a>
                <a class="mx-3" href="/registerw">Register</a>
            </div>
        @endguest
    </div>

    <div class="my-10 w-full flex justify-center">
        @yield('content')
    </div>

</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>
@include('sweetalert::alert')

<livewire:scripts>
{{--    @livewireScripts--}}

{{--    @yield('scripts')--}}
@stack('scripts')

</body>
</html>
