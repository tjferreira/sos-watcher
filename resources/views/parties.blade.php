<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SOS Watcher - Party List</title>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                height: 100vh;
                margin: 0;
            }
        </style>
    </head>
    <body>
        <ul>
        @forelse ($parties as $partyRow)
            <li><a href="parties/{{ $partyRow->party }}">{{ $partyRow->party }}</a></li>
        @empty
            <li>No parties found in database.</li>
        @endforelse
        </ul>
    </body>
</html>