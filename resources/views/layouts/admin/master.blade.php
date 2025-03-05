<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CV Paneli')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/img/admin/favicon.ico') }}" type="image/x-icon" />

    @vite(['resources/css/admin.css', 'resources/js/admin.js'])

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>

    @stack('styles')
    <!-- Fonts and icons -->
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ Vite::asset('resources/css/pages/admin/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('layouts.admin.partials.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            @include('layouts.admin.partials.header')

            <div class="container">
                @yield('content')
            </div>

            @include('layouts.admin.partials.footer')
        </div>

    </div>

    @stack('scripts')

</body>

</html>
