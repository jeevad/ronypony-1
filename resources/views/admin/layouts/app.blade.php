<!DOCTYPE html>
<html ng-app="adminApp" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ronypony') }}</title>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="/css/simplebar.css">
    <link rel="stylesheet" type="text/css" href="/assets/admin/css/app.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Scripts -->
    <script>
        window.Laravel = <?php
        echo json_encode([
                'csrfToken' => csrf_token(),
        ]);
        ?>
    </script>
    @stack('styles')
    @yield('head')
</head>
<body class="app sidebar-mini rtl">
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')
    <main class="app-content">
            @yield('content')
    </main>
    <!-- Scripts -->
    <script src="/assets/admin/js/app.js"></script>
    @stack('scripts')
</body>
</html>
