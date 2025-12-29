<?php

namespace App\Services;

use App\Models\Deal;

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
    public function getTransactionsPaginated()
    {
        $queryParams = request()->query('search');
        return Deal::where(function($query) use ($queryParams) {
            if($queryParams) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) like '%" . $queryParams . "%'");
            }
        })->paginate(20);
    }
}