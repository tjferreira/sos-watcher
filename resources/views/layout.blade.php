<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SOS Watcher - @yield('title')</title>

        <!-- Styles -->
        <style>
           html, body {
                background-color: #fff;
                color: #666;
                height: 100vh;
                margin: 0;
            }
            table {
                border-collapse: collapse;
            }
            th, td {
                padding: 3px;
                border: 1px dotted #333;
                border-collapse: collapse;
            }
            th, .heading {
                background-color: #ffdc00;
                color: #333;
            }
            .summary {
                background-color: #ff851b;
            }
            .text {
                text-align: left;
            }
            .numeric {
                text-align: right;
            }
            .narrow {
                min-width: 20px;
                max-width: 20px;
                width: 20px;
                height: 120px;
            }
            .rotate {
                -webkit-transform: rotate(-90deg);
                -moz-transform: rotate(-90deg);
                -ms-transform: rotate(-90deg);
                -o-transform: rotate(-90deg);
                padding: 0;
            }
        </style>
    </head>
    <body>
        @yield('content')
    </body>
</html>
