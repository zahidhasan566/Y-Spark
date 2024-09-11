<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>WELCOME TO Y SPARK </title>
    <meta content="Admin Dashboard" name="description">
    <meta content="Themesbrand" name="author">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('plugins/chartist/css/chartist.min.css') }}"/>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/metismenu.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .loader {
            animation: spin 1s infinite linear;
            border: solid 2vmin transparent;
            border-radius: 50%;
            border-right-color: #00ffc499;
            border-top-color: #00ffc499;
            box-sizing: border-box;
            height: 20vmin;
            left: calc(50% - 10vmin);
            position: fixed;
            top: calc(50% - 10vmin);
            width: 20vmin;
            z-index: 1;
        }

        .loader:before {
            animation: spin 2s infinite linear;
            border: solid 2vmin transparent;
            border-radius: 50%;
            border-right-color: #3cf;
            border-top-color: #3cf;
            box-sizing: border-box;
            content: "";
            height: 16vmin;
            left: 0;
            position: absolute;
            top: 0;
            width: 16vmin;
        }

        .loader:after {
            animation: spin 3s infinite linear;
            border: solid 2vmin transparent;
            border-radius: 50%;
            border-right-color: #6ff;
            border-top-color: #6ff;
            box-sizing: border-box;
            content: "";
            height: 12vmin;
            left: 2vmin;
            position: absolute;
            top: 2vmin;
            width: 12vmin;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body bgClass>
<div class="preloader" id="preloader">
    <div class="loader">
    </div>
</div>

<div id="app">
    <app></app>
</div>

<!-- jQuery  -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/js/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/plugins/dropzone/dist/dropzone.js')}}"></script>
<script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('assets/js/waves.min.js')}}"></script>
<script src="{{asset('assets/compress.js')}}"></script>
<script src="{{asset('assets/modernizr.js')}}"></script>

<!-- App js -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
