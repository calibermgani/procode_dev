<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Annexmed Product Tool') }}</title>
    @include('layouts/header_script')
    <style>
        /* Additional styling for the page */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
            background-color: #ffffff;
            /* background-image: url("assets/media/bg/login_background_3.svg"); */
            background-size: cover;
            background-position: bottom !important;
            color: white;
            position: relative;
        }

        .left-side, .right-side {
            flex: 1;
        }

        .left-side {
            background-image: url('{{ asset("assets/media/bg/login_background_4.svg") }}');
            background-size: cover;
            /* background-position: center; */
            background-repeat: no-repeat;
        }

        .right-side {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            max-width: 550px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(226, 216, 216, 0.1);
            color: #191C24;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
        }
        .copyright-container {
            position: absolute;
            bottom: 10px;
            left: 22.5rem;
            transform: translateX(-50%);
            font-size: 11px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
        }

        .copyright-container p {
            margin-right: 10px;
        }

        .copyright-container p:first-child {
            margin-right: auto;
        }

        .copyright-container p:not(:first-child) {
            color: #191C24;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="left-side"></div>
        <div class="right-side">
            <div class="login-card">
                <div class="text-left mt-0 mb-12 mb-lg-12 ml-8 mr-8">
                    <h3 class="font-size-h1">Sign In</h3>
                </div>
                @yield('content')
            </div>
        </div>
    </div>

    <div class="copyright-container">
        <p>&copy; {{ date('Y') }} Procode - All rights reserved by Annexmed &nbsp;&nbsp;&nbsp;&nbsp; &#x2709; : procodesupport@annexmed.net</p>
    </div>
</body>
@include('layouts/footer_script_login')
@include('layouts/flashMessage')
</html>
