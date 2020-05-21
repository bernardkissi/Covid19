<?php

namespace App\Console\Commands;

use App\Events\ConfirmedFromDayOneEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ConfirmedFromDayOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'corona:confirmed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all confirmed cases from day one';

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
        
        $response = Http::get('https://api.covid19api.com/dayone/country/ghana/status/confirmed');
        $data = $response->json();
        
        if (!Cache::has('confirmedFromDayOne')) {
            Cache::put('confirmedFromDayOne', $data);
        }else{
            Cache::forget('confirmedFromDayOne');
            Cache::put('confirmedFromDayOne', $data);
        }
        event(new ConfirmedFromDayOneEvent($data));
    }
}
