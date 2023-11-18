<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Support\Facades\Cache;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Cache::remember('companies', 300, fn() => Company::all());

        return CompanyResource::collection($companies);
    }
}
