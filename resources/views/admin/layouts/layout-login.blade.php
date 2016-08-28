<!DOCTYPE html>
<html>
<head>
    <title>FCG-CRM - Admin Login</title>
    <link href="/assets/admin/css/laraspace.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @include('admin.layouts.partials.favicons')
</head>
<body id="app" class="login-page">
<div class="login-wrapper">
    <div class="login-box">
        @include('admin.layouts.partials.laraspace-notifs')
        <div class="brand-main">
            <a href=""><img src="" alt="FCG-CRM Logo"></a>
        </div>
        @yield('content')
        <div class="page-copyright">
            <p>FCGCRM © 2016</p>
        </div>
    </div>
</div>
<script src="/assets/admin/js/core/plugins.js"></script>
@yield('scripts')
</body>
</html>
