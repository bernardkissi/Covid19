<?php

namespace App\Listeners;

use App\Events\CoronaGeneralEvent;
use App\Models\Statistic;
use App\Traits\Crawler\Crawler;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use DB;

class UpdateStats implements ShouldQueue
{
    use Crawler;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CoronaGeneralEvent  $event
     * @return void
     */
    public function handle(CoronaGeneralEvent $event)
    {
        if(Cache::has('summary')){
            Cache::forget('summary');
        }
        $this->save($event->data);
        $data = collect([DB::table('statistics')->latest()->first()])->all();
        Cache::put('summary', $data);
    }
}
