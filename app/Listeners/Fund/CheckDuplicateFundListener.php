<?php

namespace App\Listeners\Fund;

use App\Events\Fund\DuplicateFundWarning;
use App\Events\Fund\FundCreated;
use App\Events\Fund\FundUpdated;
use App\Models\Fund;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckDuplicateFundListener implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public function handle(FundCreated|FundUpdated $event): void
    {
        $duplicateFunds = $this->getDuplicateFunds($event);

        DuplicateFundWarning::dispatchIf(
            $duplicateFunds->isNotEmpty(),
            $event->fund
        );
    }

    private function getDuplicateFunds(FundCreated|FundUpdated $event): Collection
    {
        return Fund::query()
            ->where('manager_id', $event->fund->manager_id)
            ->where('id', '!=', $event->fund->getKey())
            ->where(function (Builder $builder) use ($event) {
                $builder
                    ->orWhere('name', $event->fund->name)
                    ->orWhere(function (Builder $builder) use ($event) {
                        foreach ($event->fund->aliases as $alias) {
                            $builder
                                ->orWhereJsonContains('aliases', $alias);
                        }
                    });
            })
            ->get();
    }
}
