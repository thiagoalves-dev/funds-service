<?php

namespace App\Providers;

use App\Events\Fund\DuplicateFundWarning;
use App\Events\Fund\FundCreated;
use App\Events\Fund\FundUpdated;
use App\Listeners\Fund\CheckDuplicateFundListener;
use App\Listeners\Fund\NotifyDuplicateFundListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        FundCreated::class => [
            CheckDuplicateFundListener::class,
        ],

        FundUpdated::class => [
            CheckDuplicateFundListener::class,
        ],

        DuplicateFundWarning::class => [
            NotifyDuplicateFundListener::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
