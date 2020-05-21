<?php

namespace App\Console\Commands;

use App\Events\RecoveredFromDayOne as Recovered;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class RecoveredFromDayOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'corona:recovered';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all recovered from day one of outbreak';

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
        
        $response = Http::get('https://api.covid19api.com/dayone/country/ghana/status/recovered');
        $data = $response->json();
        
        event(new Recovered($data));
    }
}
