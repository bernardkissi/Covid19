<?php

namespace App\Console\Commands;

use App\Traits\Crawler\Crawler;
use Illuminate\Console\Command;


class CoronaUpdates extends Command
{
    use Crawler;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'corona:updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get corona updates from worldmeters';

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
        $this->fetchPage(); 
    }
}
