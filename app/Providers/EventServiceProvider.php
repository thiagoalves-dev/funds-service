<?php

namespace App\Providers;

use App\Events\Fund\DuplicateFundWarning;
use App\Events\Fund\FundCreated;
use App\Events\Fund\FundUpdated;
use App\Listeners\Fund\CheckDuplicatedFundListener;
use App\Listeners\Fund\NotifyDuplicatedFundListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        FundCreated::class => [
            CheckDuplicatedFundListener::class,
        ],

        FundUpdated::class => [
            CheckDuplicatedFundListener::class,
        ],

        DuplicateFundWarning::class => [
            NotifyDuplicatedFundListener::class,
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
