<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SOS Watcher - {{ $candidate }}</title>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                height: 100vh;
                margin: 0;
            }
            td {
                padding: 3px;
            }
        </style>
    </head>
    <body>
    <h3>{{ $candidate }}</h3>
    <table>
        <tr>
            <th style="text-align: right;">County</th>
            <th style="text-align: right;">Votes</th>
        </tr>
        @forelse ($results as $currentResult)
            <tr>
                <td style="text-align: right;">{{ $currentResult->name }}</td>
                <td style="text-align: right;">{{ number_format($currentResult->votes,0) }}</td>
            </tr>
        @empty
            <tr>No results found in database.</tr>
        @endforelse
    </table>    
    </body>
</html>
