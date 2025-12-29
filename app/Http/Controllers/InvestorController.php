<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvestorDetailResource;
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
        $investors = $this->investorService->getInvestorsPaginated();

        if ($investors->isEmpty()) {
            return $this->errorResponse(message: 'No Investor found.');
        }

        $data = [
            'data' => InvestorResource::collection($investors->items()),
            'per_page' => $investors->perPage(),
            'total' => $investors->total()
        ];

        return $this->successResponse(message: 'Success! Investor list.', data: $data);
    }

    public function investorDetail(int $id)
    {
        $investor = $this->investorService->getInvestorDetail($id);

        if (!$investor) {
            return $this->errorResponse(message: 'Investor not found.');
        }

        $data = new InvestorDetailResource($investor);

        return $this->successResponse(message: 'Success! Investor Detail.', data: $data);
    }
}
