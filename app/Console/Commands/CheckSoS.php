<?php

namespace App\Console\Commands;

use App\Candidate;
use App\County;
use App\Inquery;
use App\Race;
use App\Result;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Client;

class CheckSoS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'digistack:check-sos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check SOS for updated information';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $BASE_URL = "https://api.sos.ca.gov/";
        $RETURNS_URL = $BASE_URL . "returns/";
        $STATUS_URL = $RETURNS_URL . "status/";

        $lastInquery = Inquery::orderBy('created_at', 'desc')->take(1)->first();
        if($lastInquery == null) {
            $lastReportTimestamp = 201806050001;
        } else {
            $lastReportTimestamp = $lastInquery->lastUpdate;
        }

        $client = new Client();
        $result = $client->request('GET', $STATUS_URL);

        if($result->getStatusCode() == 200) {
            $rawBody = $result->getBody();
            $body = json_decode($rawBody);

            $newReportTimestamp = $body->statewide->lastReportTimestamp;

            $inquery = new Inquery;
            $inquery->lastUpdate = $newReportTimestamp;
            $inquery->response = $rawBody;
            $inquery->save();

            if($lastReportTimestamp >= $newReportTimestamp) {
                $this->info("No Updates since " . $lastReportTimestamp);
            } else {
                $this->info("Updates Found " . $newReportTimestamp . " > " . $lastReportTimestamp);
                $countyList = [];
                foreach($body as $key => $value) {
                    if($key != "statewide") {
                        if($value->lastReportTimestamp >= $lastReportTimestamp) {
                            $countyList[] = $key;
                            $this->info($key . " " . $value->lastReportTimestamp);
                        }
                    }
                }
    
//                    ,"ballot-measures"

                $defaultRaceList = [
                    "governor"
                    ,"lieutenant-governor"
                    ,"secretary-of-state"
                    ,"controller"
                    ,"treasurer"
                    ,"attorney-general"
                    ,"insurance-commissioner"
                    ,"superintendent-of-public-instruction"
                    ,"us-senate"
                    ,"board-of-equalization/district/1"
                    ,"board-of-equalization/district/2"
                    ,"board-of-equalization/district/3"
                    ,"board-of-equalization/district/4"
                    ,"us-rep/district/1"
                    ,"us-rep/district/2"
                    ,"us-rep/district/3"
                    ,"us-rep/district/4"
                    ,"us-rep/district/5"
                    ,"us-rep/district/6"
                    ,"us-rep/district/7"
                    ,"us-rep/district/8"
                    ,"us-rep/district/9"
                    ,"us-rep/district/10"
                    ,"us-rep/district/11"
                    ,"us-rep/district/12"
                    ,"us-rep/district/13"
                    ,"us-rep/district/14"
                    ,"us-rep/district/15"
                    ,"us-rep/district/16"
                    ,"us-rep/district/17"
                    ,"us-rep/district/18"
                    ,"us-rep/district/19"
                    ,"us-rep/district/20"
                    ,"us-rep/district/21"
                    ,"us-rep/district/22"
                    ,"us-rep/district/23"
                    ,"us-rep/district/24"
                    ,"us-rep/district/25"
                    ,"us-rep/district/26"
                    ,"us-rep/district/27"
                    ,"us-rep/district/28"
                    ,"us-rep/district/29"
                    ,"us-rep/district/30"
                    ,"us-rep/district/31"
                    ,"us-rep/district/32"
                    ,"us-rep/district/33"
                    ,"us-rep/district/34"
                    ,"us-rep/district/35"
                    ,"us-rep/district/36"
                    ,"us-rep/district/37"
                    ,"us-rep/district/38"
                    ,"us-rep/district/39"
                    ,"us-rep/district/40"
                    ,"us-rep/district/41"
                    ,"us-rep/district/42"
                    ,"us-rep/district/43"
                    ,"us-rep/district/44"
                    ,"us-rep/district/45"
                    ,"us-rep/district/46"
                    ,"us-rep/district/47"
                    ,"us-rep/district/48"
                    ,"us-rep/district/49"
                    ,"us-rep/district/50"
                    ,"us-rep/district/51"
                    ,"us-rep/district/52"
                    ,"us-rep/district/53"
                    ,"state-senate/district/2"
                    ,"state-senate/district/4"
                    ,"state-senate/district/6"
                    ,"state-senate/district/8"
                    ,"state-senate/district/10"
                    ,"state-senate/district/12"
                    ,"state-senate/district/14"
                    ,"state-senate/district/16"
                    ,"state-senate/district/18"
                    ,"state-senate/district/20"
                    ,"state-senate/district/22"
                    ,"state-senate/district/24"
                    ,"state-senate/district/26"
                    ,"state-senate/district/28"
                    ,"state-senate/district/30"
                    ,"state-senate/district/32"
                    ,"state-senate/district/34"
                    ,"state-senate/district/36"
                    ,"state-senate/district/38"
                    ,"state-senate/district/40"
                    ,"state-assembly/district/1"
                    ,"state-assembly/district/2"
                    ,"state-assembly/district/3"
                    ,"state-assembly/district/4"
                    ,"state-assembly/district/5"
                    ,"state-assembly/district/6"
                    ,"state-assembly/district/7"
                    ,"state-assembly/district/8"
                    ,"state-assembly/district/9"
                    ,"state-assembly/district/10"
                    ,"state-assembly/district/11"
                    ,"state-assembly/district/12"
                    ,"state-assembly/district/13"
                    ,"state-assembly/district/14"
                    ,"state-assembly/district/15"
                    ,"state-assembly/district/16"
                    ,"state-assembly/district/17"
                    ,"state-assembly/district/18"
                    ,"state-assembly/district/19"
                    ,"state-assembly/district/20"
                    ,"state-assembly/district/21"
                    ,"state-assembly/district/22"
                    ,"state-assembly/district/23"
                    ,"state-assembly/district/24"
                    ,"state-assembly/district/25"
                    ,"state-assembly/district/26"
                    ,"state-assembly/district/27"
                    ,"state-assembly/district/28"
                    ,"state-assembly/district/29"
                    ,"state-assembly/district/30"
                    ,"state-assembly/district/31"
                    ,"state-assembly/district/32"
                    ,"state-assembly/district/33"
                    ,"state-assembly/district/34"
                    ,"state-assembly/district/35"
                    ,"state-assembly/district/36"
                    ,"state-assembly/district/37"
                    ,"state-assembly/district/38"
                    ,"state-assembly/district/39"
                    ,"state-assembly/district/40"
                    ,"state-assembly/district/41"
                    ,"state-assembly/district/42"
                    ,"state-assembly/district/43"
                    ,"state-assembly/district/44"
                    ,"state-assembly/district/45"
                    ,"state-assembly/district/46"
                    ,"state-assembly/district/47"
                    ,"state-assembly/district/48"
                    ,"state-assembly/district/49"
                    ,"state-assembly/district/50"
                    ,"state-assembly/district/51"
                    ,"state-assembly/district/52"
                    ,"state-assembly/district/53"
                    ,"state-assembly/district/54"
                    ,"state-assembly/district/55"
                    ,"state-assembly/district/56"
                    ,"state-assembly/district/57"
                    ,"state-assembly/district/58"
                    ,"state-assembly/district/59"
                    ,"state-assembly/district/60"
                    ,"state-assembly/district/61"
                    ,"state-assembly/district/62"
                    ,"state-assembly/district/63"
                    ,"state-assembly/district/64"
                    ,"state-assembly/district/65"
                    ,"state-assembly/district/66"
                    ,"state-assembly/district/67"
                    ,"state-assembly/district/68"
                    ,"state-assembly/district/69"
                    ,"state-assembly/district/70"
                    ,"state-assembly/district/71"
                    ,"state-assembly/district/72"
                    ,"state-assembly/district/73"
                    ,"state-assembly/district/74"
                    ,"state-assembly/district/75"
                    ,"state-assembly/district/76"
                    ,"state-assembly/district/77"
                    ,"state-assembly/district/78"
                    ,"state-assembly/district/79"
                    ,"state-assembly/district/80"
                ];

                foreach($countyList as $county){

                    $storeCountyRacePair = false;
                    //TODO: Should scrub county before using it in a query since it comes from an outside source
                    $currentCounty = County::firstOrCreate(['name' => $county]);

                    $raceList = [];
                    if(count($currentCounty->races)) {
                        foreach($currentCounty->races as $race) {
                            $raceList[] = $race->name;
                        }
                    } else {
                        $raceList = $defaultRaceList;
                    }

                    foreach($raceList as $race) {
                        try {
                            $currentURL = $RETURNS_URL . $race."/county/".$county;
                            $result = $client->request('GET', $currentURL);

                            if($result->getStatusCode() == 200) {

                                $body = json_decode($result->getBody());

                                if(isset($body->candidates)) {

                                    $currentRace = Race::firstOrCreate(
                                        ['name' => $race
                                        ,'county_id' => $currentCounty->id
                                        ],
                                        ['title' => $body->raceTitle
                                        ,'reporting' => $body->Reporting
                                        ,'reportingTime' => $body->ReportingTime
                                        ,'candidateCount' => count($body->candidates)
                                        ]
                                    );

                                    foreach($body->candidates as $candidate) {
                                        $currentCandidate = Candidate::updateOrCreate(
                                            ['name' => $candidate->Name
                                            ,'race' => $currentRace->name
                                            ],
                                            ['party' => $candidate->Party
                                            ,'incumbent' => $candidate->incumbent
                                            ]
                                        );

                                        $currentCandidate->counties()->attach($currentCounty);
                                        $currentCandidate->races()->attach($currentRace);

                                        $currentResult = Result::updateOrCreate(
                                            ['race_id' => $currentRace->id
                                            ,'candidate_id' => $currentCandidate->id
                                            ],
                                            ['votes' => str_replace(",", "", $candidate->Votes)
                                            ,'percentage' => $candidate->Percent
                                            ]
                                        );
                                    }
                                }
                            }            
                        } catch (ServerException $e) {
                        }
                    }
                }
            }
        }
    }
}