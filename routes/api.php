<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\TransactionController;
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
    Route::get('investors/{id}', [InvestorController::class, 'investorDetail'])->where('id', '[0-9]+');

    /**
     * Transactions
     */
    Route::get('deals', [TransactionController::class, 'dealList']);
    Route::get('payouts', [TransactionController::class, 'payoutList']);
    Route::get('payouts/{id}', [TransactionController::class, 'payoutDetail'])->where('id', '[0-9]+');
    Route::post('payouts/{id}', [TransactionController::class, 'payoutSave']);



});