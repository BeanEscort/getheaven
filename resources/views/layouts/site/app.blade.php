<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cemitérios') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fonts/line-awesome/css/line-awesome-font-awesome.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">

    @livewireStyles

</head>

<body>
    <div id="app">
	@if (Route::has('login'))
                <div class="fixed top-0 right-4 sm:px-6 lg:px-8 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dash') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 ">Login</a>

                    @endauth
                </div>
        @endif
	
        <main class="py-4">
            @yield('content')
        </main>

    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    @livewireScripts

</body>

</html>
