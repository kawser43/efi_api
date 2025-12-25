<?php

namespace App\Http\Controllers;

use App\Http\Resources\CampaignResource;
use App\Services\CampaignService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function __construct(private CampaignService $campaignService)
    {
    }

    public function campaignList()
    {
        $campaigns = $this->campaignService->getCampaignsPaginated();

        if ($campaigns->isEmpty()) {
            return $this->errorResponse(message: 'No campaigns found.');
        }

        $data = [
            'data' => CampaignResource::collection($campaigns->items()),
            'per_page' => $campaigns->perPage(),
            'total' => $campaigns->total()
        ];

        return $this->successResponse(message: 'Success! Campaign list.', data: $data);
    }
}
