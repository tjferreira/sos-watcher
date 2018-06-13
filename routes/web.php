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
    $lastUpdate = Carbon\Carbon::parse(DB::table('inqueries')->max('lastUpdate'))->diffForHumans();
    $lastCheck = Carbon\Carbon::parse(DB::table('inqueries')->max('created_at'))->diffForHumans();
    $data = compact('lastUpdate', 'lastCheck');
    return View::make('welcome', $data);
});

Route::get('/parties', function () {
    //List of parties
    $parties = DB::table('candidates')->select('party')->distinct()->get();
    $data = compact('parties');
    return View::make('parties', $data);
});

Route::get('/parties/{party}', function ($party) {
    //List of candidates by party
    $candidates = DB::table('candidates')
        ->select('candidates.name', 'candidates.race', DB::raw('sum(results.votes) as sumVotes'))
        ->where('party', $party)
        ->leftJoin('results', 'candidates.id', '=', 'results.candidate_id')
        ->orderBy('race', 'asc')
        ->groupBy('candidates.name', 'candidates.race')
        ->get();
    $data = compact('party', 'candidates');
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
        ->select('candidates.name', 'candidates.race', DB::raw('sum(results.votes) as sumVotes'))
        ->where('race', $race)
        ->leftJoin('results', 'candidates.id', '=', 'results.candidate_id')
        ->orderBy('sumVotes', 'dsc')
        ->groupBy('candidates.name', 'candidates.race')
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