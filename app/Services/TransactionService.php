<?php

namespace App\Services;

use App\Models\User;

class TransactionService
{
    public function getTransactionsPaginated()
    {
        $queryParams = request()->query('search');
        return User::where(function($query) use ($queryParams) {
            if($queryParams) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) like '%" . $queryParams . "%'");
            }
        })->paginate(20);
    }
}