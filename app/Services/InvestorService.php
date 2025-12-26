<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\User;

class InvestorService
{
    public function getInvestorsPaginated()
    {
        $queryParams = request()->query('search');
        return User::where(function($query) use ($queryParams) {
            if($queryParams) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) like '%" . $queryParams . "%'");
            }
        })->paginate(20);
    }
}