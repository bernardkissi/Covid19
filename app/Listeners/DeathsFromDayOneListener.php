<?php

namespace App\Listeners;

use App\Events\DeathsFromDayOne;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class DeathsFromDayOneListener implements ShouldQueue
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
    public function handle(DeathsFromDayOne $event)
    {
        if (!Cache::has('deathFromDayOne')) {
            Cache::put('deathFromDayOne', $event->data);
        }else{
            Cache::forget('deathFromDayOne');
            Cache::put('deathFromDayOne', $event->data);
        }
    }
}
