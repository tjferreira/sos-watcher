<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SOS Watcher - {{ $party }} Party</title>

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
    <h3>{{ ucfirst($party) }} Party Candidates</h3>
    <table>
        <tr>
            <th><div class="rotate">Race</div></th>
            <th><div class="rotate">Candidate</div></th>
            <th class="summary"><div class="rotate">Total</div></th>
            @foreach ($counties as $countyColumn)
                <th class="narrow"><div class="rotate">{{ $countyColumn->name }}</div></th>
            @endforeach
        </tr>
        @forelse ($candidates as $candidateRow)
            <tr>
                <td class="heading text"><a href="/races/<?=str_replace('/', '|', $candidateRow->race)?>"><?=ucwords(str_replace('-', ' ', str_replace('/', ' ', $candidateRow->race)))?></td>
                <td class="heading text"><a href="/races/<?=str_replace('/', '|', $candidateRow->race)?>/candidates/<?=str_replace('"', '_',str_replace('.', '|', $candidateRow->name))?>">{{ $candidateRow->name }}</a></td>
                <td class="numeric summary">{{ number_format($candidateRow->sumVotes,0) }}</td>
                @foreach ($counties as $countyColumn)
                    <?php $found = false; ?>
                    @foreach ($candidateRow->results as $result)
                        @if($countyColumn->name == $result->race->county->name)
                            <?php $found = true; ?>
                            <td class="numeric">{{ number_format($result->votes,0) }}<br />{{ number_format($result->percentage,1) }}%</th>
                            @break
                        @endif()
                    @endforeach
                    @if($found == false)
                        <td class="numeric">&nbsp;</th>
                    @endif()
                @endforeach
            </tr>
        @empty
            <tr>No candidates found in database.</tr>
        @endforelse
    </table>

    
    </body>
</html>
