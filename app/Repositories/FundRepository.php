<?php

namespace App\Repositories;

use App\Models\Fund;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class FundRepository
{
    public function search(array $filters): Collection
    {
        return Fund::query()
            ->where(function (Builder $builder) use ($filters) {
                if ($name = Arr::get($filters, 'name')) {
                    $builder->where('name', 'like', "%$name%");
                }

                if ($managerId = Arr::get($filters, 'manager_id')) {
                    $builder->where('manager_id', $managerId);
                }

                if ($startYear = Arr::get($filters, 'start_year')) {
                    $builder->where('start_year', $startYear);
                }
            })
            ->orderBy('name')
            ->get();
    }

    public function getSimilarFunds(Fund $fund): Collection
    {
        return Fund::query()
            ->where('manager_id', $fund->manager_id)
            ->where('id', '!=', $fund->getKey())
            ->where(function (Builder $builder) use ($fund) {
                $builder
                    ->orWhere('name', $fund->name)
                    ->orWhere(function (Builder $builder) use ($fund) {
                        foreach ($fund->aliases as $alias) {
                            $builder
                                ->orWhereJsonContains('aliases', $alias);
                        }
                    });
            })
            ->get();
    }
}
