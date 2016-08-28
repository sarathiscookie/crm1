<!DOCTYPE html>
<html>
<head>
    <title>FCGCRM - @yield('title')</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
    <script src="/assets/admin/js/core/pace.js"></script>
    <link href="/assets/admin/css/laraspace.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @include('admin.layouts.partials.favicons')
    @yield('styles')
    @include('analytics')
    <style>
        .loading-icn {
            background-color: #ffffff;
            background-image: url("/assets/admin/img/loading.gif");
            background-size: 25px 25px;
            background-position:right center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body id="app" class="layout-default">
    @include('admin.layouts.partials.laraspace-notifs')
    @include('admin.layouts.partials.header')
    <div class="mobile-menu-overlay"></div>
    @include('admin.layouts.partials.sidebar',['type' => 'default'])

    @yield('content')

    @include('admin.layouts.partials.footer')
    @if(config('laraspace.skintools'))
        @include('admin.layouts.partials.skintools')
    @endif
    <script src="/assets/admin/js/core/plugins.js"></script>
    <script src="/assets/admin/js/demo/skintools.js"></script>
    @yield('scripts')
    <script>
        //Header Nav bar Search
        $('#searchkey').keyup( function () {
            var val = $(this).val();
            if (val.length >= 2) {
                $('#searchkey').addClass('loading-icn');
                $.get("/admin/search", {key: val})
                        .done(function (data) {
                            $('#searchkey').removeClass('loading-icn');
                            if (data.result != '') {
                                $('#navSrchBox').html(data.result).show();
                            }
                            else {
                                $('#navSrchBox').html('<div class="alert alert-danger" role=alert><span>No results</span></div>').show();
                            }
                        });
            }
            else {
                $("#navSrchBox").html('').hide();
            }
        });

        //Toggle search results when clicking inside input holds previous keyword
        $('#searchkey').click( function () {
            if($("#navSrchBox").html()!='' && $("#navSrchBox").css('display') == 'none') {
                $('#navSrchBox').show();
            }
        });

        //Toggle search container display on page click
        $(document).mouseup(function (e)
        {
            var container = $("#navSrchBox");
            // if the target of the click isn't the container...nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.hide();
            }
        });
        //csrf token for AJAX Request
        var token = "{{ csrf_token() }}";
        jQuery.ajaxSetup({
            headers: {'X-CSRF-Token': token}
        });
    </script>
</body>
</html>
