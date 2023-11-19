<?php

namespace App\Http\Requests\Api\Fund;

use Illuminate\Foundation\Http\FormRequest;

class FundIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'manager_id' => 'nullable|integer|exists:managers,id',
            'name'       => 'nullable|max:255',
            'start_year' => 'nullable|date_format:Y',
        ];
    }
}
