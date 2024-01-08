<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Spiros</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_KEY') }}"></script>
    <link href="{{asset('assets/general/css/toaster.css')}}" rel="stylesheet" type="text/css">

    <style>
        @import "https://fonts.googleapis.com/css?family=Quicksand";

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {    
            min-height: 100vh;
            background-image: linear-gradient(#17082e 0%, #1a0933 7%, #1a0933 80%, #0c1f4c 100%);
            text-shadow: 0 0 1px rgba(50, 251, 226, 0.3), 0 0 2px rgba(50, 251, 226, 0.3), 0 0 5px rgba(50, 251, 226, 0.2);
        }

        body {
            font-family: "Quicksand", sans-serif;
            font-weight: 500;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        h1 {
            font-weight: 700;
            color: #32fbe2;
            text-align: center;
            line-height: 1.5em;
            margin-bottom: 1.2em;
            margin-top: 0.2em;
            text-shadow: 0 0 1px rgba(50, 251, 226, 0.6), 0 0 3px rgba(50, 251, 226, 0.5), 0 0 0.5rem rgba(50, 251, 226, 0.3), 0 0 2rem rgba(50, 251, 226, 0.2);
        }

        a {
            font-size: 0.98em;
            color: #8a97a0;
            text-decoration: none;
        }

        a:hover {
            color: rgb(233, 23, 41);
        }
    
        .container {
            display: flex;
            -webkit-display: box;
            -moz-display: box;
            -ms-display: flexbox;
            -webkit-display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-content: center;
            padding: 3%;
            margin: 0;
            margin-top: 30px;
        }

        form {
            background-color: #1c123a;
            padding: 2em;
            padding-bottom: 3em;
            border-radius: 8px;
            max-width: 400px;
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 0 1px rgba(255, 255, 255, 0.3), 0 0 2px rgba(255, 255, 255, 0.3), 0 0 5px rgba(255, 255, 255, 0.2);
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;

            
        }

        form input {
            color: #31fbe2;
            background-color: #250d49;
            box-shadow: 0 0 1px rgba(255, 255, 255, 0.3), 0 0 2px rgba(255, 255, 255, 0.3), 0 0 5px rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 4px;
            padding: 1em;
            margin-bottom: 1.2em;
            width: 100%;
        }

        form input:focus {
            outline: none;
        }

        .button {
            font-weight: 600;
            text-align: center;
            font-size: 19px;
            color: #FFF;
            background-color: #6f43c1;
            width: 100%;
            border: none;
            border-radius: 4px;
            padding: 0.8em;
            margin-top: 1.4em;
            margin-bottom: 1em;
            cursor: pointer;
            overflow: hidden;
            transition: all 200ms ease-in-out;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);
        }

        .button:hover {
            box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.3);
            transform: translateY(-4px);
        }

        .button span {
            position: relative;
            z-index: 1;
        }

        .button .circle {
            position: absolute;
            z-index: 0;
            background-color: #35A556;
            border-radius: 50%;
            transform: scale(0);
            opacity: 5;
            height: 50px;
            width: 50px;
        }

        .button .circle.animate {
            animation: grow 0.5s linear;
        }

        @keyframes grow {
            to {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        .button .signup-message {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: space-between;
            color: red;
        }

        .danger {
            color: red;
        }

        .logo-div {

            width: 100px;
            margin: 0px auto;
            margin-top: 40px;
            font-weight: bold;
            text-align: center
        }
    </style>
</head>

<body>

    <h1 class="logo-div" style="width: auto;">Glam Production</h1>
    <div class="container">
        <form id="loginForm" action="{{route('login')}}" method="post">
            @csrf
            <h1>
                {{__('Sign in')}}
            </h1>
            <div class="form-content">
                <input id="user-name" name="email" placeholder="Email" type="email" />
                <input id="password" name="password" placeholder="password" type="password" /><br />

                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                <div class="g-recaptcha rc-anchor-light-custom" id="feedback-recaptcha" data-sitekey="{!! env('GOOGLE_RECAPTCHA_KEY') !!}"></div>
                @error('g-recaptcha-response')
                <span class="danger" style="font-size: 12px">{{__('Please Check reCaptcha')}}</span><br>
                @enderror
                <br>
                <button type="submit" class="button">
                    Log in
                </button>
                <br />

                <div class="signup-message">
                    <a class="danger">@error('email'){{$message}}@enderror</a>
                </div>
            </div>
        </form>
    </div>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var alertData = {!! json_encode(session("alert")) !!};

        if (alertData) {
            toastr[alertData.type](alertData.message);
        }
    });
</script>
</html>