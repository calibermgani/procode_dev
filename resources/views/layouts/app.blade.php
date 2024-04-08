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
            color: white;
            position: relative;
        }

        .left-side, .right-side {
            flex: 1;
        }

        .left-side {
            background-image: url('{{ asset("assets/media/bg/login_background_4.svg") }}');
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .right-side {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
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

            .left-side {
                min-height: 200px; /* Adjust as needed */
            }

            .right-side {
                padding: 20px 0;
            }

            .copyright-container {
                position: relative; /* Change to relative */
                text-align: center;
                margin-top: 20px;
                left:11rem !important;
            }

            .copyright-container p {
                color: black; /* Change text color to black */
            }
        }

        @media (max-width: 480px) {
            .copyright-container p {
                color: black; /* Change text color to black for smaller screens */
            }
            .copyright-container {
                left:0rem !important;
            }
        }
        @media (max-width: 321px) {
            .copyright-container p {
                color: black; /* Change text color to black for smaller screens */
            }
            .copyright-container {
                left:0rem !important;
            }
        }

        .copyright-container {
            position: absolute; /* Keep absolute positioning */
            bottom: 10px; /* Adjust as needed */
            left: 3.5rem; /* Set left to 0 */
            right: 0; /* Set right to 0 */
            text-align: center; /* Center text */
            font-size: 11px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 10px;
            width: 100%;
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
        <div class="left-side">
            <!-- Left side content -->
        </div>
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
