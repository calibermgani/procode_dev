<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<?php
$currentURL = URL::current();
$routex = explode('/', Route::current()->uri());
$current_page = Route::getFacadeRoot()
    ->current()
    ->uri();
$url_segment = Request::segment(1);
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>{{ config('app.name', 'Annexmed Product Tool') }}</title>
    @include('layouts/header_script')

</head>
<style>
    .con {
        width: 250px;
        height: 200px;
    }

    .cle {
        width: 260px;
        height: 260px;
    }

    .vp {
        width: 150px;
        height: 150px;
        position: absolute;
        bottom: 10%;
        left: 22%;
    }

    .header_2 {
        position: absolute;
        top: 0%;
    }
</style>

<body>
    <div class="d-flex flex-column flex-root">
        <div class="login login-3 login-signin-on d-flex flex-column flex-lg-row flex-row-fluid bg-white auth auth-img-bg"
            id="kt_login">
            <div class="login-aside d-flex flex-row-auto bgi-size-cover bgi-no-repeat p-5 p-lg-10"
                style="background-image: url(assets/media/bg/bg-11.jpg);">
                <div class="d-flex flex-row-fluid flex-column justify-content-between">
                    <a href="#" class="flex-column-auto">
                        {{-- <img src="assets/media/logos/logo-white.png" class="max-h-80px" alt="" /> //need to change logo --}}
                    </a>
                    <div class="d-none flex-column-auto d-lg-flex justify-content-between mt-10">
                        <div class="opacity-40 font-weight-bold text-white">© {{ date('Y') }} AnnexMed</div>
                        <div class="d-flex">
                            <p href="#" class="opacity-40 text-white">Privacy</p>
                            <p href="#" class="opacity-40 text-white ml-10">Legal</p>
                            <p href="#" class="opacity-40 text-white ml-10">Contact</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-row-fluid d-flex flex-column position-relative p-7 overflow-hidden">
                <div class="d-flex flex-column-fluid flex-center mt-5 mt-lg-0">
                    <div class="login-form login-signin auth-form-transparent">
                        <div class="text-left  mb-10 mb-lg-10">
                            <h3 class="font-size-h1">Sign In</h3>
                            <p class="text-muted font-weight-bold">Enter your username and password</p>
                        </div>
                        @yield('content')
                    </div>
                    <div class="login-form login-forgot">
                        <div class="text-center mb-10 mb-lg-20">
                            <h3 class="font-size-h1">Forgotten Password?</h3>
                            <p class="text-muted font-weight-bold">Enter your email to reset your password</p>
                        </div>
                        <form class="form" novalidate="novalidate" id="kt_login_forgot_form">
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="email"
                                    placeholder="Email" name="email" autocomplete="off" />
                            </div>
                            <div class="form-group d-flex flex-wrap flex-center">
                                <button type="button" id="kt_login_forgot_submit"
                                    class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Submit</button>
                                <button type="button" id="kt_login_forgot_cancel"
                                    class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="d-flex d-lg-none flex-column-auto flex-column flex-sm-row justify-content-between align-items-center p-5"
        style="background-image: url(assets/media/bg/bg-11.jpg);">
        <div class="text-white font-weight-bold order-2 order-sm-1 my-2">© 2022 Annexmed</div>
        <div class="d-flex order-1 order-sm-2 my-2">
            <a href="#" class="text-dark-75 text-hover-primary">Privacy</a>
            <a href="#" class="text-dark-75 text-hover-primary ml-4">Legal</a>
            <a href="#" class="text-dark-75 text-hover-primary ml-4">Contact</a>
        </div>
    </div>
</body>

@include('layouts/footer_script_login')
@include('layouts/flashMessage')

</html>
