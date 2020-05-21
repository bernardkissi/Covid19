<?php

namespace App\Console\Commands;

use App\Events\TotalFromDayOneEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TotalFromDayOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'corona:totalSummary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets all summary from day one';

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
        $response = Http::get('https://coronavirus-19-api.herokuapp.com/all');
        $data = $response->json();
        $collection = collect($data);
        $merged = $collection->merge(['updated' => now()]);
        
        event(new TotalFromDayOneEvent($merged->all()));
    }
}
