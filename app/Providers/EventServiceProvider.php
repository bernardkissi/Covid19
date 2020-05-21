<?php

namespace App\Providers;

use App\Events\ConfirmedFromDayOneEvent;
use App\Events\CoronaDailyEvent;
use App\Events\CoronaGeneralEvent;
use App\Events\CoronaWeeklyEvent;
use App\Events\DeathsFromDayOne;
use App\Events\RecoveredFromDayOne;
use App\Events\TotalFromDayOneEvent;
use App\Listeners\ConfirmedFromDayOneListener;
use App\Listeners\CoronaDailyListener;
use App\Listeners\CoronaSummaryFromDayOneListener;
use App\Listeners\CoronaWeeklyListener;
use App\Listeners\DeathsFromDayOneListener;
use App\Listeners\RecoveredFromDayOneListener;
use App\Listeners\UpdateStats;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        CoronaDailyEvent::class => [ CoronaDailyListener::class ],
        CoronaGeneralEvent::class => [ UpdateStats::class ],
        CoronaWeeklyEvent::class => [ CoronaWeeklyListener::class ],
        TotalFromDayOneEvent::class => [CoronaSummaryFromDayOneListener::class ],
        ConfirmedFromDayOneEvent::class => [ConfirmedFromDayOneListener::class ],
        CoronaRegionalEvent::class => [ RegionalUpdateListener::class ],
        DeathsFromDayOne::class => [ DeathsFromDayOneListener::class],
        RecoveredFromDayOne::class => [ RecoveredFromDayOneListener::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
