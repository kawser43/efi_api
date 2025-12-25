<?php

namespace App\Services;

use App\Models\Campaign;

class CampaignService
{
    public function getCampaignsPaginated()
    {
        $queryParams = request()->query('search');
        return Campaign::where(function($query) use ($queryParams) {
            if($queryParams) {
                $query->where('project_name', 'like', '%' . $queryParams . '%');
            }
        })->paginate(20);
    }
}