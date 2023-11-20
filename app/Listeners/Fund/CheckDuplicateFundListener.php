<?php

namespace App\Listeners\Fund;

use App\Events\Fund\DuplicateFundWarning;
use App\Events\Fund\FundCreated;
use App\Events\Fund\FundUpdated;
use App\Repositories\FundRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckDuplicateFundListener implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public function handle(FundCreated|FundUpdated $event): void
    {
        $duplicateFunds = (new FundRepository)->getSimilarFunds($event->fund);

        DuplicateFundWarning::dispatchIf(
            $duplicateFunds->isNotEmpty(),
            $event->fund
        );
    }
}
