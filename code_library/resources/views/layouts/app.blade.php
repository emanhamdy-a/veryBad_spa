<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Argon Dashboard') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/sidepage.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/jstree/default/style.css"  rel="stylesheet">

    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            @include('layouts.navbars.sidebar')
        @endauth

        <div class="main-content">
            @include('layouts.navbars.navbar')
            @yield('content')
        </div>
        <div id="mySidenav" class="sidenav"tyle='position:absolute;z-index:11111;'>
          <a href="javascript:void(0)" class="closebtn closNv" onclick="closeNav()">&times;</a>
          <ul class="nav">
            <li><a class='cod btn btn-lighter text-lighter' style='cursor:pointer;'><i class="fa fa-code m-2 ml-4"></i>Code</a></li>
            <li><a class='exp btn btn-lighter text-lighter' style='cursor:pointer;'><i class="fa fa-book m-2"></i>Explaine</a></li>
          </ul>
          <div class="tabcontent">
            <div id="cod" class="">
              <textarea class='text-lighter cd border col-11 m-5 p-5' style='border-radius:10px;min-height:400px;background-color:#111111;'></textarea>
            </div>
            <div id="exp" class="" style='display:none;'>
              <textarea class='text-lighter ex border col-11 m-5 p-5' style='border-radius:10px;min-height:400px;background-color:#111111;'></textarea>
            </div>
          </div>
        </div>

        <!-- <span class='opnv' onclick="openNav()" style='position:absolute;left:99px;z-index:111;'>open</span> -->

        <!-- Use any element to open the sidenav -->
        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        @stack('js')

        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
        <script src="{{ asset('argon') }}/js/search.js"></script>

        <script src="{{ asset('argon') }}/jstree/js/jstree.js"></script>
        <script src="{{ asset('argon') }}/jstree/js/jstree.checkbox.js"></script>
        <script src="{{ asset('argon') }}/jstree/js/jstree.types.js"></script>
        <script src="{{ asset('argon') }}/jstree/js/jstree.wholerow.js"></script>
    </body>
</html>
