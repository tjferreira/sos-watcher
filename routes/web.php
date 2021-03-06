<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //Home page
    $lastUpdateAbsolute =Carbon\Carbon::createFromFormat('YmdHi', DB::table('inqueries')->max('lastUpdate'), 'America/Los_Angeles')->toDateTimeString();
    $lastUpdate =Carbon\Carbon::createFromFormat('YmdHi', DB::table('inqueries')->max('lastUpdate'), 'America/Los_Angeles')->diffForHumans();
    $lastCheck = Carbon\Carbon::parse(DB::table('inqueries')->max('created_at'))->diffForHumans();
    $data = compact('lastUpdateAbsolute', 'lastUpdate', 'lastCheck');
    return View::make('welcome', $data);
});

Route::get('/parties', function () {
    //List of parties
    $parties = DB::table('candidates')->select('party')->distinct()->get();
    $data = compact('parties');
    return View::make('parties', $data);
});

Route::get('/parties/{party}', function ($party) {
    //List of candidates by party and then sumup votes for whole state
    $candidates = App\Candidate::with('results.race.county')->where('party', $party)->get();
    foreach($candidates as $candidate) {
        $sumVotes = 0;
        foreach($candidate->results as $result) {
            $sumVotes += $result->votes;
        }
        $candidate->sumVotes = $sumVotes;
        $opponents = DB::table('candidates')
        ->select('candidates.name', 'candidates.party', 'candidates.race', DB::raw('sum(results.votes) as sumVotes'))
        ->where('race', $candidate->race)
        ->leftJoin('results', 'candidates.id', '=', 'results.candidate_id')
        ->orderBy('sumVotes', 'dsc')
        ->groupBy('candidates.name', 'candidates.party', 'candidates.race')
        ->get();
        $candidate->opponentCount = count($opponents);
        $candidate->leader = $opponents[0];
        if(count($opponents) > 1) {
            $candidate->secondPlace = $opponents[1];
        } else {
            $candidate->secondPlace = $opponents[0];
        }
        $candidate->median = $opponents[floor(count($opponents)/2)];
        $candidate->last = $opponents[count($opponents)-1];

        $totalVotes = 0;
        foreach($opponents as $opponent) {
            $totalVotes = $totalVotes + $opponent->sumVotes;
        }
        $candidate->totalVotes = $totalVotes;
    }
    $counties = App\County::get();
    $data = compact('party', 'candidates', 'counties');
    return View::make('party', $data);
});

Route::get('/races', function () {
    //List of races
    $races = DB::table('candidates')->select('race')->distinct()->orderBy('race', 'asc')->get();
    $data = compact('races');
    return View::make('races', $data);
});

Route::get('/races/{race}', function ($race) {
    //Race details
    $race = str_replace('|', '/', $race);
    $candidates = DB::table('candidates')
        ->select('candidates.name', 'candidates.party', 'candidates.race', DB::raw('sum(results.votes) as sumVotes'))
        ->where('race', $race)
        ->leftJoin('results', 'candidates.id', '=', 'results.candidate_id')
        ->orderBy('sumVotes', 'dsc')
        ->groupBy('candidates.name', 'candidates.party', 'candidates.race')
        ->get();
    $totalVotes = 0;
    foreach($candidates as $candidate) {
        $totalVotes = $totalVotes + $candidate->sumVotes;
    }
    $mean = $totalVotes / count($candidates);
    $data = compact('race', 'candidates', 'totalVotes', 'mean');
    return View::make('race', $data);
});

Route::get('/races/{race}/candidates/{candidate}', function ($race, $candidate) {
    //Candidate details
    $candidate = str_replace('|', '.', $candidate);
    $candidate = str_replace('_', '"', $candidate);
    $race = str_replace('|', '/', $race);
    $candidateRow = DB::table('candidates')
        ->where(['race' => $race, 'name' => $candidate])
        ->get();
    $results = DB::table('results')
        ->where('candidate_id', $candidateRow[0]->id)
        ->leftJoin('races', 'races.id', '=', 'results.race_id')
        ->leftJoin('counties', 'counties.id', '=', 'races.county_id')
        ->get();
    $data = compact('race','candidate','candidateRow','results');
    return View::make('candidate', $data);
});