<!DOCTYPE html>
<html>
    <head>
        <title>Admin authenticate | @yield('title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Load CSS -->
        {{ HTML::style('packages/king/backend/css/bootstrap.css') }}
        {{ HTML::style('packages/king/backend/css/font-awesome.css') }}
        {{ HTML::style('packages/king/backend/css/style.css') }}
    </head>
    <body>

        @yield('body')

        <!-- Load JS -->
        {{ HTML::script('packages/king/backend/js/jquery_v1.5.1.js') }}
        {{ HTML::script('packages/king/backend/js/bootstrap.js') }}
        {{ HTML::script('packages/king/backend/js/script.js') }}
    </body>
</html>
