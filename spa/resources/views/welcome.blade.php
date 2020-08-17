<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
      <meta name="user-nm" content="{{ Auth::user()->name }}">
      <script>window.laravel={
      csrfToken:'{{ csrf_token() }}',
      userNm:"{{ Auth::user()->name }}",
      userId:"{{ Auth::user()->id }}",
      }
      </script>
    @else
      <script>window.laravel={
      csrfToken:'{{ csrf_token() }}',
      //  user_nm:user->name,
      }
      </script>
    @endauth
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

  </head>
  <body>
    <div id="app">
      <main-app/>
      <!-- <example-component> </example-component> -->
      <router-view></router-view>
    </div>
      <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>
