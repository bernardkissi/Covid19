<?php

namespace App\Listeners;

use App\Events\CoronaWeeklyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class CoronaWeeklyListener implements ShouldQueue
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
    public function handle(CoronaWeeklyEvent $event)
    {
        if (!Cache::has('weekly')) {
            Cache::put('weekly', $event->data);
        }else{
            Cache::forget('weekly');
            Cache::put('weekly', $event->data);
        }
    }
}
