<?php

namespace App\Listeners;

use App\Events\CoronaDailyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class CoronaDailyListener implements ShouldQueue
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
    public function handle(CoronaDailyEvent $event)
    {
        if (!Cache::has('daily')) {
            Cache::put('daily', $event->data);
        }else{
            Cache::forget('daily');
            Cache::put('daily', $event->data);
        }
    }
}
