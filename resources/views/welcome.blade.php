<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SOS Watcher - Home</title>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                min-height: 100vh;
                margin: 0;
            }

            .full-height {
                min-height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
                padding: 0 20%;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <p>This is a deployment of the github-hosted, Laravel-based project: <a href="https://github.com/tjferreira/sos-watcher">tjferreira/sos-watcher</a>.</p>

                <h2>Brief Analysis</h2>
                <p>As of June 12, the turnout is reported at 30%. Given the 141k registered Libertarians in the state, we can assume about 42.5k Libertarians voted. Any statewide candidate above 42.5k most likely attracted non-Libertarian voters. For sure, any statewide candidate above 141k attracted non-Libertarian voters. I'm still working on the code to calculate these numbers on the fly for non-statewide candidates. My full analysis will wait until the data and code is finalized, but browse and draw some of your own conclusions while we wait.</p>

                <p>Last update posted to SOS Website: {{ $lastUpdateAbsolute }} ({{ $lastUpdate}}). Last check of SOS Website: {{$lastCheck}}.</p>

                <p><a href="/parties/lib">All Libertarian Candidates</a></p>
                <p><a href="/races">All Races</a></p>
                <p><a href="/parties">All Parties</a></p>

                <h2>History</h2>
                <p>On election night (June 5th, 2018) I was refreshing California Secretary of State webpages every 30 minutes or so to see real-time results. The next day, I was downloading csv files to analyze the results. However, the results were constantly changing and the processes of downloading was becoming tedious. Then I noticed the pattern in the csv file URLs and I wrote a script to downlaod the results for me. Then I noticed that the csv download was using an <a href="https://api.sos.ca.gov/">API</a> endpoint. I visited that endpoint and there was a full blown API for downloding results.</p>
                <p>This code started as a query to that API every few mimnutes to see if there have been any updates. If not, the code goes back to sleep for 5 minutes. If so, the code determines the minimum number of requests it must make to find all the updated data and then makes those requests.</p>
                <p>At this point, over the weekend, my plan was to write a blog post showing the data analysis I was doing on the election results. However, each time I thought I was done with the post, new data would arrive and slightly change the analysis. So I created a nice table of a data snapshot so the post could be internally consistent. I was almost ready to post last night when I realized I had written two-thirds of a decent web application. So I started converting everything into this open source project. I fired up a sub-domain and a server. Now, the data tables you see on this site are always up to date.</p>

                <h2>Future</h2>
                <p>This is just the first version to answer some immediate questions I was pondering. I plan make the presentation better and expand on this code further. Including a tie-in to the FPPC data for each campaign. For this I need to generate a mapping between the race and candidate on the SOS site and the FPPC ID number. If you have questions, ideas, or code suggestions, let me know through a github <a href="https://github.com/tjferreira/sos-watcher/issues/new">issue</a>.</p>

                <h3>In Liberty,<br />
                Tim "TJ" Ferreira
                </h3>
            </div>
        </div>
    </body>
</html>
