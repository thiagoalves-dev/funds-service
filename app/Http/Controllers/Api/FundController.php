<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Fund\FundIndexRequest;
use App\Http\Requests\Api\Fund\FundStoreAndUpdateRequest;
use App\Http\Resources\FundResource;
use App\Models\Fund;
use App\Repositories\FundRepository;

class FundController extends Controller
{
    public function index(FundIndexRequest $request)
    {
        $funds = (new FundRepository)->search($request->validated());

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
