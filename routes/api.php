<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
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
     *  ########### Campaigns ##########
     *  ###########################
     */
    Route::get('campaigns', [CampaignController::class, 'campaignList']);


});