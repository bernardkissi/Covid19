<?php

namespace App\Listeners;

use App\Events\CoronaRegionalEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class RegionalUpdateListener implements ShouldQueue
{
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
     * @param  object  $event
     * @return void
     */
    public function handle(CoronaRegionalEvent $event)
    {
       if(Cache::has('regional')){
            Cache::forget('regional');
        }
        $regions = collect([Region::all()])->all();
        Cache::put('regional', $regions);
    }
}
