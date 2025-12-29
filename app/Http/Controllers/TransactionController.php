<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvestorDetailResource;
use App\Http\Resources\InvestorResource;
use App\Services\InvestorService;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function __construct(private TransactionService $transactionService)
    {
    }

    public function transactionList()
    {
        $investors = $this->transactionService->getTransactionsPaginated();

        if ($investors->isEmpty()) {
            return $this->errorResponse(message: 'No transaction found.');
        }

        $data = [
            'data' => InvestorResource::collection($investors->items()),
            'per_page' => $investors->perPage(),
            'total' => $investors->total()
        ];

        return $this->successResponse(message: 'Success! Transaction list.', data: $data);
    }

    public function transactionSave()
    {
        //
    }
}
