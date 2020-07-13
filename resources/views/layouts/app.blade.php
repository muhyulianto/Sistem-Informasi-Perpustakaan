<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Perpustakaan') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link
          href="{{ asset('fonts/fontawesome/fontawesome/css/font-awesome.css') }}"
          rel="stylesheet"
    />
  </head>
  <body id="particles-js">
    <div id="app">
      <app></app>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>
