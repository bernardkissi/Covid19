<?php

namespace App\Listeners;

use App\Events\TotalFromDayOneEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CoronaSummaryFromDayOneListener implements ShouldQueue
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
    public function handle(TotalFromDayOneEvent $event)
    {
        Log::info($event->data);
        if (!Cache::has('world')) {
            Cache::put('world', $event->data);
        }else{
            Cache::forget('world');
            Cache::put('world', $event->data);
        }
    }
}
