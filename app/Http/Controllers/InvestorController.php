<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvestorResource;
use App\Services\InvestorService;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function __construct(private InvestorService $investorService)
    {
    }
    public function investorList()
    {
        $campaigns = $this->investorService->getInvestorsPaginated();

        if ($campaigns->isEmpty()) {
            return $this->errorResponse(message: 'No campaigns found.');
        }

        $data = [
            'data' => InvestorResource::collection($campaigns->items()),
            'per_page' => $campaigns->perPage(),
            'total' => $campaigns->total()
        ];

        return $this->successResponse(message: 'Success! Campaign list.', data: $data);
    }
}
