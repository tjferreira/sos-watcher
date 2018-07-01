@extends('layout')

@section('title', 'Party List' )

@section('content')
        <h3>Political Parties</h3>
        <table>
            <tr>
                <th style="text-align: right;">Party Name</th>
                <th style="text-align: right;">Party Abbreviation</th>
            </tr>
            @forelse ($parties as $partyRow)
                <tr>
                @switch($partyRow->party)
                @case("Lib")
                    <td style="text-align: right;"><a href="parties/{{ $partyRow->party }}">Libertarian</a></td>
                    @break
                @case("Dem")
                    <td style="text-align: right;"><a href="parties/{{ $partyRow->party }}">Democrat</a></td>
                    @break
                @case("Rep")
                    <td style="text-align: right;"><a href="parties/{{ $partyRow->party }}">Republican</a></td>
                    @break
                @case("Grn")
                    <td style="text-align: right;"><a href="parties/{{ $partyRow->party }}">Green</a></td>
                    @break
                @case("P&F")
                    <td style="text-align: right;"><a href="parties/{{ $partyRow->party }}">Peace and Freedom</a></td>
                    @break
                @case("NPP")
                    <td style="text-align: right;"><a href="parties/{{ $partyRow->party }}">No Party Preference</a></td>
                    @break
                @case("Non")
                    <td style="text-align: right;"><a href="parties/{{ $partyRow->party }}">No Registered Party</a></td>
                    @break
                @case("AI")
                    <td style="text-align: right;"><a href="parties/{{ $partyRow->party }}">American Independent</a></td>
                    @break
                @default
                    <td style="text-align: right;"><a href="parties/{{ $partyRow->party }}">{{ $partyRow->party }}</a></td>
            @endswitch
                    <td style="text-align: right;"><a href="parties/{{ $partyRow->party }}">{{ $partyRow->party }}</a></td>
                </tr>
            @empty
                <tr>No parties found in database.</tr>
            @endforelse
        </table>    
@endsection
