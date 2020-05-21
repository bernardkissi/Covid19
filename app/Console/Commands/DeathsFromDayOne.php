<?php

namespace App\Console\Commands;

use App\Events\DeathsFromDayOne as Deaths;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class DeathsFromDayOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'corona:deaths';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all deaths from day of outbreak';

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
        $response = Http::get('https://api.covid19api.com/dayone/country/ghana/status/deaths');
        $data = $response->json();
        
        event(new Deaths($data));
    }
}
