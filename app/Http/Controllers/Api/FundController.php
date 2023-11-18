<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Fund\FundStoreRequest;
use App\Http\Resources\FundResource;
use App\Models\Fund;

class FundController extends Controller
{
    public function store(FundStoreRequest $request)
    {
        $fund = Fund::query()->create($request->validated());

        return new FundResource($fund);
    }

    public function show(Fund $fund)
    {
        return new FundResource($fund);
    }
}
