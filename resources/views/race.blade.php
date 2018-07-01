@extends('layout')

@section('title', $race . ' Race' )

@section('content')
    <h1><?=ucwords(str_replace('-', ' ', str_replace('/', ' ', $race)))?> Candidates</h1>
    <table>
        <tr>
            <th style="text-align: left;">Candidate Name</th>
            <th style="text-align: left;">Party</th>
            <th style="text-align: right;">Votes</th>
            <th style="text-align: right;">Curve %</th>
            <th style="text-align: right;">Total</th>
            <th style="text-align: right;">%</th>
            <th style="text-align: right;">Mean</th>
            <th style="text-align: right;">Deviation</th>
        </tr>
        @forelse ($candidates as $candidateRow)
            <tr>
                <td><a href="/races/<?=str_replace('/', '|', $candidateRow->race)?>/candidates/<?=str_replace('"', '_',str_replace('.', '|', $candidateRow->name))?>">{{ $candidateRow->name }}</a></td>
                <td style="text-align: right;"><a href="/parties/{{ $candidateRow->party }}">{{$candidateRow->party}}</a></td>
                <td style="text-align: right;">{{ number_format($candidateRow->sumVotes,0) }}</td>
                <td style="text-align: right;">{{ number_format($candidateRow->sumVotes / $candidates[0]->sumVotes * 100, 1) }}</td>
                <td style="text-align: right;">{{ number_format($totalVotes,0) }}</td>
                <td style="text-align: right;">{{ number_format($candidateRow->sumVotes / $totalVotes * 100, 1) }}</td>
                <td style="text-align: right;">{{ number_format($mean,0) }}</td>
                <td style="text-align: right;">{{ number_format($candidateRow->sumVotes - $mean, 0)}}</td>
            </tr>
        @empty
            <tr>No candidates found in database.</tr>
        @endforelse
    </table>
@endsection
