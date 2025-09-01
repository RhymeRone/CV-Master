<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CV Paneli')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/img/admin/favicon.ico') }}" type="image/x-icon" />

    @vite(['resources/css/admin.css'])

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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <!-- jQuery Scrollbar CDN (yedek olarak) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.scrollbar/0.2.11/jquery.scrollbar.min.js"></script>

    @vite(['resources/js/admin.js'])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
                    window.logout = function() {
                        let apiServices = window.apiService;
                        apiServices.request({
                            url: '/logout',
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            actions: {
                                success: {
                                    redirect: '/login',
                                    redirectTimer: 2000,
                                },
                                errors: {
                                    message: 'Bir hata oluştu',
                                }
                            }
                });
            }
        });
    </script>

    @stack('scripts')

</body>

</html>
