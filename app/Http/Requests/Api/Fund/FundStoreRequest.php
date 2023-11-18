<?php

namespace App\Http\Requests\Api\Fund;

use Illuminate\Foundation\Http\FormRequest;

class FundStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'manager_id' => 'required|integer|exists:managers,id',
            'name'       => 'required|max:255',
            'start_year' => 'required|date_format:Y',
            'aliases'    => 'required|array|min:1',
            'aliases.*'  => 'required|string|max:20',
        ];
    }
}
