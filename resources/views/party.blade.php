@extends('layout')

@section('title', $party . ' Party List' )

@section('content')
    <h3>{{ ucfirst($party) }} Party Candidates</h3>
    <table>
        <tr>
            <th><div class="rotate">Race</div></th>
            <th><div class="rotate">Candidate</div></th>

            <th class="summary"><div class="rotate">Total</div></th>
            <th class="summary"><div class="rotate">%</div></th>
            <th class="summary"><div class="rotate">Turnout</div></th>
            <th class="summary"><div class="rotate">Candidates In Race</div></th>

            <th>&nbsp;</th>

            <th class="summary"><div class="rotate">1st Curve %</div></th>
            <th class="summary"><div class="rotate">2nd Curve %</div></th>
            <th class="summary"><div class="rotate">Median Curve %</div></th>
            <th class="summary"><div class="rotate">Last Curve %</div></th>

            <th>&nbsp;</th>

            <th class="summary"><div class="rotate">Leader Votes</div></th>
            <th class="summary"><div class="rotate">Second Votes</div></th>
            <th class="summary"><div class="rotate">Median</div></th>
            <th class="summary"><div class="rotate">Last</div></th>

            @foreach ($counties as $countyColumn)
                <th class="narrow"><div class="rotate">{{ $countyColumn->name }}</div></th>
            @endforeach
        </tr>
        @forelse ($candidates as $candidateRow)
            <tr>
                <td class="heading text"><a href="/races/<?=str_replace('/', '|', $candidateRow->race)?>"><?=ucwords(str_replace('-', ' ', str_replace('/', ' ', $candidateRow->race)))?></td>
                <td class="heading text"><a href="/races/<?=str_replace('/', '|', $candidateRow->race)?>/candidates/<?=str_replace('"', '_',str_replace('.', '|', $candidateRow->name))?>">{{ $candidateRow->name }}</a></td>

                <td class="numeric summary">{{ number_format($candidateRow->sumVotes,0) }}</td>
                <td class="numeric summary">{{ number_format($candidateRow->sumVotes / $candidateRow->totalVotes * 100,1) }}%</td>
                <td class="numeric summary">{{ number_format($candidateRow->totalVotes,0) }}</td>
                <td class="numeric summary">{{ number_format($candidateRow->opponentCount,0) }}</td>

                <td class="heading text">&nbsp;</td>

                <td class="numeric summary">{{ number_format($candidateRow->sumVotes/$candidateRow->leader->sumVotes * 100,1) }}%</td>
                <td class="numeric summary">{{ number_format($candidateRow->sumVotes/$candidateRow->secondPlace->sumVotes * 100,1) }}%</td>
                <td class="numeric summary">{{ number_format($candidateRow->sumVotes/$candidateRow->median->sumVotes * 100,1) }}%</td>
                <td class="numeric summary">{{ number_format($candidateRow->sumVotes/$candidateRow->last->sumVotes * 100,1) }}%</td>

                <td class="heading text">&nbsp;</td>

                <td class="numeric summary">{{ number_format($candidateRow->leader->sumVotes,0) }}</td>
                <td class="numeric summary">{{ number_format($candidateRow->secondPlace->sumVotes,0) }}</td>
                <td class="numeric summary">{{ number_format($candidateRow->median->sumVotes,0) }}</td>
                <td class="numeric summary">{{ number_format($candidateRow->last->sumVotes,0) }}</td>

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
@endsection