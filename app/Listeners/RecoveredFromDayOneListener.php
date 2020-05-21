<?php

namespace App\Listeners;

use App\Events\RecoveredFromDayOne;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class RecoveredFromDayOneListener implements ShouldQueue
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
    public function handle(RecoveredFromDayOne $event)
    {
       if (!Cache::has('recoveredFromDayOne')) {
            Cache::put('recoveredFromDayOne', $event->data);
        }else{
            Cache::forget('recoveredFromDayOne');
            Cache::put('recoveredFromDayOne', $event->data);
        }
    }
}
