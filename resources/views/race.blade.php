<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SOS Watcher - {{ $race }} Race</title>

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
    <h1>{{ $race }} Candidates</h1>
    <table>
        <tr>
            <th style="text-align: left;">Candidate Name</th>
            <th style="text-align: right;">Votes</th>
            <th style="text-align: right;">Total</th>
            <th style="text-align: right;">%</th>
            <th style="text-align: right;">Mean</th>
            <th style="text-align: right;">Deviation</th>
        </tr>
        @forelse ($candidates as $candidateRow)
            <tr>
                <td><a href="/races/<?=str_replace('/', '|', $candidateRow->race)?>/candidates/{{ $candidateRow->name }}">{{ $candidateRow->name }}</a></td>
                <td style="text-align: right;">{{ number_format($candidateRow->sumVotes,0) }}</td>
                <td style="text-align: right;">{{ number_format($totalVotes,0) }}</td>
                <td style="text-align: right;">{{ number_format($candidateRow->sumVotes / $totalVotes * 100, 1) }}</td>
                <td style="text-align: right;">{{ number_format($mean,0) }}</td>
                <td style="text-align: right;">{{ number_format($candidateRow->sumVotes - $mean, 0)}}</td>
            </tr>
        @empty
            <tr>No candidates found in database.</tr>
        @endforelse
    </table>

    
    </body>
</html>
