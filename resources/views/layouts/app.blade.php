<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<?php
$currentURL = URL::current();
$routex = explode('/', Route::current()->uri());
$current_page = Route::getFacadeRoot()->current()->uri();
$url_segment = Request::segment(1);
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Annexmed Product Tool') }}</title>
    @include('layouts/header_script')
    <style>
        /* Additional styling for the page */
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .login-container {
            display: flex;
            flex-direction: column;
            min-height: 100%;
            background-color: #ffffff;
            background-image: url("assets/media/bg/login_background_3.svg");
            background-size: cover;
            background-position: bottom !important;
            color: white;
            position: relative;
            /* Position relative for absolute positioning of bottom elements */
        }

        .left-side,
        .right-side {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .left-side img {
            width: 100%;
            max-width: 200px;
            /* Adjust as needed */
            height: auto;
            /* Maintain aspect ratio */
            margin-bottom: 20px;
        }

        .header-logo {
            position: absolute;
            top: 20px;
            /* Adjust as needed */
            left: 20px;
            /* Adjust as needed */
            width: 80px;
            /* Decreased width */
        }

        .login-text {
            text-align: center;
            margin-bottom: 20px;
        }

        .right-side {
            position: relative;
            /* Position relative for absolute positioning of .login-card */
            padding: 20px;
            /* Added padding */
        }

        .login-card {
            max-width: 550px;
            width: 100%;
            background-color: #ffffff;
            /* Black background color */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(226, 216, 216, 0.1);
            margin-bottom: 0px;
            color: #191C24;
            /* Text color */
            position: absolute;
            right: 12rem;
        }


        .login-card form {
            margin-bottom: 0;
        }

        .company-logo {
            position: absolute;
            bottom: 16px;
            /* Adjust as needed */
            /* right: 35px; */
            /* Adjust as needed */
            width: 100px;
        }

        /* .copyright-container {
            margin-top: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            border-top: 1px solid white;
            padding-top: 10px;
            width: calc(100% - 40px);
            padding-left: 20px;
        } */

        .copyright-container {
            position: absolute;
            bottom: 10px;
            /* Adjust as needed */
            left: 90px;
            /* Adjust as needed */
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            /* Distribute items evenly */
            align-items: center;
            /* Vertically center items */
            /* border-top: 1px solid white; */
            /* White separation line */
            padding-top: 10px;
            /* Adjust spacing between line and text */
            width: calc(100% - 11%);
        }

        .copyright-container p {
            margin-right: 10px;
            /* Adjust spacing between items */
        }

        .copyright-container p:first-child {
            margin-right: auto;
            /* Push the first item to the left */
        }
        .copyright-container p:not(:first-child) {
            color:#191C24;
            font-weight:500;
        }


        @media (min-width: 768px) {
            .login-container {
                flex-direction: row;
            }

            .right-side {
                padding: 20px 40px;
                /* Adjust padding for larger screens */
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        {{-- <div class="left-side">
            <img src="assets/media/bg/procode_logo.svg" alt="Header Logo" class="header-logo">
            <img src="{{ asset('/assets/media/bg/collegue_Image.svg') }}" alt="Logo"
                style="width: 100%; max-width: 700px; height: auto; margin-bottom: 20px;">
                <img src="{{ asset('/assets/media/bg/login_product_Image_default.svg') }}" alt="Logo"
                style="width: 100%; max-width: 700px; height: auto; margin-bottom: 20px;">

        </div> --}}
        <div class="right-side">
            <div class="login-card">
                <div class="text-left  mt-0 mb-12 mb-lg-12 ml-8 mr-8">
                    <h3 class="font-size-h1">Sign In</h3>
                    {{-- <p class="login-subtext mt-4">Enter your username and password</p> --}}
                </div>
                @yield('content')
            </div>
        </div>

        {{-- <img src="{{ asset('/assets/media/bg/annexmed_logo.svg') }}" alt="Company Logo" class="company-logo"> --}}
    </div>
    <div class="copyright-container">
        <p>&copy; {{ date('Y') }} Pro coding</p>
        <p href="#">Privacy</p>
        <p href="#">Legal</p>
        <p href="#">Contact</p>
        <p> <img src="{{ asset('/assets/media/bg/annexmed_logo_1.svg') }}" alt="Company Logo" class="company-logo"></p>

    </div>
</body>
@include('layouts/footer_script_login')
@include('layouts/flashMessage')

</html>
