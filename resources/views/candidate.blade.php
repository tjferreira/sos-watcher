@extends('layout')

@section('title', $candidate )

@section('content')
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
@endsection