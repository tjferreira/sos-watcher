<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SOS Watcher - Race List</title>

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
        @forelse ($races as $raceRow)
            <li><a href="races/<?=str_replace('/', '|', $raceRow->race)?>">{{ $raceRow->race }}</a></li>
        @empty
            <li>No races found in database.</li>
        @endforelse
        </ul>
    </body>
</html>