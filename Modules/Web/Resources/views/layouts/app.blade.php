<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TVN - PAPERLESS - LOGIN</title>

    <!-- Fonts -->
    <link href="/css/fontawesome.css" type="text/css" rel="stylesheet">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>
<body class="fixed-left">
<div id="root">
    <main>
        @yield('content')
    </main>
</div>
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
