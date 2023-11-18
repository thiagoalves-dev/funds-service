<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManagerResource;
use App\Models\Manager;
use Illuminate\Support\Facades\Cache;

class ManagerController extends Controller
{
    public function index()
    {
        $managers = Cache::remember('managers', 300, fn() => Manager::all());

        return ManagerResource::collection($managers);
    }
}
