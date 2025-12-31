<?php

namespace App\Services;

use App\Models\Deal;
use App\Models\Payout;

class TransactionService
{
    public function getDealsPaginated()
    {
        $queryParams = request()->query('search');
        return Deal::where(function($query) use ($queryParams) {
            if($queryParams) {
                $query->where("deal_record_id", $queryParams);
            }
        })->paginate(20);
    }
    public function getPayoutsPaginated()
    {
        $queryParams = request()->query('search');
        return Payout::with(['transactions', 'campaign', 'user'])->where(function($query) use ($queryParams) {
            if($queryParams) {
                $query->where("deal_id", $queryParams);
            }
        })->paginate(20);
    }

    public function getPayoutDetails($id)
    {
        return Payout::with(['transactions', 'campaign', 'user'])->findOrFail($id);
    }
}