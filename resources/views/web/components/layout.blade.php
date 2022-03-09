<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home 01</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/fontawesome-5.0.8/css/fontawesome-all.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <!--===============================================================================================-->

    <style>
        .custom-dropdown-menu li {
            position: relative;
        }

        .custom-dropdown-menu .dropdown-submenu {
            display: none;
            position: absolute;
            left: 100%;
            top: -7px;
        }

        .custom-dropdown-menu .dropdown-submenu-left {
            right: 100%;
            left: auto;
        }

        .custom-dropdown-menu>li:hover>.dropdown-submenu {
            display: block;
        }

        li>a.custom-dropdown-item.active::before {
            content: "";
            display: block;
            position: absolute;
            width: calc(100% + 36px);
            height: 5px;
            bottom: 0;
            left: -18px;
            background-color: #e6e6e6;
            transition: all 0.3s;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            -moz-transition: all 0.3s;

            -webkit-transform: scaleX(0);
            -moz-transform: scaleX(0);
            -ms-transform: scaleX(0);
            -o-transform: scaleX(0);
            transform: scaleX(0);
        }

        li>a.custom-dropdown-item.active::after {
            content: "\f2f9";
            font-family: Material-Design-Iconic-Font;
            font-size: 16px;
            color: #222;
            line-height: 1.5;
            margin-left: 6px;
            margin-bottom: 1px;
            transition: all 0.3s;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            -moz-transition: all 0.3s;
        }

        li:hover>a.custom-dropdown-item.active:after {
            color: #fff;
        }

        li>a.custom-dropdown-item.active {
            display: flex;
            justify-content: space-between;
        }

        .image-cover {
            background: transparent;
            /* border: 1px solid #34495e; */
            /* width: 200px; */
            height: 200px;
            object-fit: contain;
            object-position: center;
        }

        .breadcrumb-item {
            float: left;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

    </style>

</head>

<body class="animsition">

    <x-header></x-header>

    {{ $slot }}

    <x-footer></x-footer>

    <x-back-to-top></x-back-to-top>

    <!--===============================================================================================-->
    <script src="{{ asset('js/app.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('js/main.js') }}"></script>
    <!--===============================================================================================-->

    @stack('scripts')

</body>

</html>
