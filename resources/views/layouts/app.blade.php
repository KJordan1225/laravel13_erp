<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel ERP')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <div class="erp-wrapper">
            @include('partials.sidebar')

            <div class="erp-main">
                @include('partials.navbar')

                <main class="erp-content">
                    @include('partials.alerts')
                    @yield('content')
                </main>

                @include('partials.footer')
            </div>
        </div>

        <toast-notifications></toast-notifications>
    </div>
</body>
</html>