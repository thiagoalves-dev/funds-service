<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FundResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->resource->getKey(),
            'manager'    => new ManagerResource($this->resource->manager),
            'name'       => $this->resource->name,
            'start_year' => $this->resource->start_year,
            'aliases'    => $this->resource->aliases,
        ];
    }
}
