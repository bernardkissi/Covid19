<?php

namespace App\Console\Commands;

use App\Events\CoronaWeeklyEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CoronaWeekly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'corona:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get corona weekly updates from postman api';

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
        $response = Http::get('https://api.quarantine.country/api/v1/spots/week?region=ghana');
        $data = $response->json();
        
        event(new CoronaWeeklyEvent($data));
    }
}
