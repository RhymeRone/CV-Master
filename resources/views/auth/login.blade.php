<!DOCTYPE html>
<html lang="tr">
<head>
    <title>{{ config('app.name') }} - Giriş</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- Vite ile tüm asset'leri yükle --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('{{ asset('assets/img/bg-01.jpg') }}');">
            <div class="wrap-login100">
                <form id="loginForm" class="login100-form" autocomplete="off">
                    <span class="login100-form-logo">
                        <i class="zmdi zmdi-landscape"></i>
                    </span>

                    <span class="login100-form-title p-b-34 p-t-27">
                        Hoşgeldin
                    </span>

                    <div class="wrap-input100">
                        <input class="input100" type="email" name="email" placeholder="Email">
                        <span class="focus-input100" data-placeholder="&#xf207;"></span>
                    </div>

                    <div class="wrap-input100">
                        <input class="input100" type="password" name="password" placeholder="Şifre">
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>

                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="remember" type="checkbox" name="remember">
                        <label class="label-checkbox100" for="remember">
                            Beni Hatırla
                        </label>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Giriş Yap
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>