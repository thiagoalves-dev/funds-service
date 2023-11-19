<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Fund\FundIndexRequest;
use App\Http\Requests\Api\Fund\FundStoreAndUpdateRequest;
use App\Http\Resources\FundResource;
use App\Models\Fund;
use Illuminate\Database\Eloquent\Builder;

class FundController extends Controller
{
    public function index(FundIndexRequest $request)
    {
        $funds = Fund::query()
            ->where(function (Builder $builder) use ($request) {
                if ($name = $request->get('name')) {
                    $builder->where('name', 'like', "%$name%");
                }

                if ($managerId = $request->get('manager_id')) {
                    $builder->where('manager_id', $managerId);
                }

                if ($startYear = $request->get('start_year')) {
                    $builder->where('start_year', $startYear);
                }
            })
            ->orderBy('name')
            ->get();

        return FundResource::collection($funds);
    }

    public function store(FundStoreAndUpdateRequest $request)
    {
        $fund = Fund::query()->create($request->validated());

        return new FundResource($fund);
    }

    public function show(Fund $fund)
    {
        return new FundResource($fund);
    }

    public function update(Fund $fund, FundStoreAndUpdateRequest $request)
    {
        $fund->update($request->validated());

        return new FundResource($fund->refresh());
    }

    public function destroy(Fund $fund)
    {
        $fund->delete();

        return response()
            ->json([
                'message' => 'Fund deleted successfully!',
            ], 200);
    }
}
