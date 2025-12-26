<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\InvestorController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    /** ###########################
     *  ########### Auth ##########
     *  ###########################
     */
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    /** ###########################
     *  ########### Reports ##########
     *  ###########################
     */
    Route::get('campaigns', [CampaignController::class, 'campaignList']);
    Route::get('investors', [InvestorController::class, 'investorList']);


});