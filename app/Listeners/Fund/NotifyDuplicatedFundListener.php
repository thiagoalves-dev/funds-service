<?php

namespace App\Listeners\Fund;

use App\Events\Fund\DuplicateFundWarning;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyDuplicatedFundListener implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public function handle(DuplicateFundWarning $event): void
    {
        echo "Notify that {$event->fund->name} is duplicated! \n";
    }
}
