<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAPERLESS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/css/vuetify.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/style.css">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <script src="/js/socket.js"></script>
    <script src="/js/app.js?v=1906031121" defer></script>
</head>
<body>
<div id="root">
    @yield('content')
</div>
<script>
    @auth
        window.Permissions = {!! json_encode(Auth::user()->allPermissions, true) !!};
        window.Roles = {!! json_encode(Auth::user()->role, true) !!};
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), 'user' => Auth::user()]) !!};
    @else
        window.Permissions = [];
        window.Roles = [];
    @endauth
</script>
{{-- Laravel Mix - JS File --}}
{{-- <script src="{{ mix('js/web.js') }}"></script> --}}
</body>
</html>
