<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Fund\FundStoreAndUpdateRequest;
use App\Http\Resources\FundResource;
use App\Models\Fund;

class FundController extends Controller
{
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
