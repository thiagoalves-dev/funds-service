<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\FundController;
use App\Http\Controllers\Api\ManagerController;
use Illuminate\Support\Facades\Route;

Route::resource('companies', CompanyController::class, ['only' => ['index']]);

Route::resource('managers', ManagerController::class, ['only' => ['index']]);

Route::resource('funds', FundController::class, ['only' => ['store']]);
