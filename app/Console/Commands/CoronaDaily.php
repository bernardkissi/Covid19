<?php

namespace App\Console\Commands;

use App\Events\CoronaDailyEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;


class CoronaDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'corona:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get overall stats from corona-api.com';

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
        $response = Http::get('https://api.quarantine.country/api/v1/summary/region?region=ghana');
        $data = $response->json();
        
        event(new CoronaDailyEvent($data));
    }
}
//https://corona-api.com/countries/GH