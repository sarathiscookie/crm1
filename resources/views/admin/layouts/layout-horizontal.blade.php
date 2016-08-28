<!DOCTYPE html>
<html>
<head>
    <title>Laraspace - Laravel Admin</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
    <script src="/assets/admin/js/core/pace.js"></script>
    <link href="/assets/admin/css/laraspace.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @include('admin.layouts.partials.favicons')
    @yield('styles')
    @include('analytics')
</head>
<body id="app" class="layout-horizontal">
    @include('admin.layouts.partials.laraspace-notifs')
    @include('admin.layouts.partials.header')
    <div class="mobile-menu-overlay"></div>
    @include('admin.layouts.partials.header-bottom')
    @yield('content')
    @include('admin.layouts.partials.footer')
    @include('admin.layouts.partials.skintools')
    <script src="/assets/admin/js/core/plugins.js"></script>
    <script src="/assets/admin/js/demo/skintools.js"></script>
    @yield('scripts')
</body>
</html>
