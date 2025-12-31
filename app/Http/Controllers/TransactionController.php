<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayoutRequest;
use App\Http\Resources\DealResource;
use App\Http\Resources\InvestorDetailResource;
use App\Http\Resources\InvestorResource;
use App\Http\Resources\PayoutDetailResource;
use App\Http\Resources\PayoutResource;
use App\Services\InvestorService;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function __construct(private TransactionService $transactionService)
    {
    }

    public function dealList()
    {
        $deals = $this->transactionService->getDealsPaginated();

        if ($deals->isEmpty()) {
            return $this->errorResponse(message: 'No deals found.');
        }

        $data = [
            'data' => DealResource::collection($deals->items()),
            'per_page' => $deals->perPage(),
            'total' => $deals->total()
        ];

        return $this->successResponse(message: 'Success! Deal list.', data: $data);
    }

    public function payoutList()
    {
        $payouts = $this->transactionService->getPayoutsPaginated();

        if ($payouts->isEmpty()) {
            return $this->errorResponse(message: 'No transaction found.');
        }

        $data = [
            'data' => PayoutResource::collection($payouts->items()),
            'per_page' => $payouts->perPage(),
            'total' => $payouts->total()
        ];

        return $this->successResponse(message: 'Success! Transaction list.', data: $data);
    }

    public function payoutDetail(int $id)
    {
        $payout = $this->transactionService->getPayoutDetails($id);

        if (!$payout) {
            return $this->errorResponse(message: 'No transaction found.');
        }

        $data = new PayoutDetailResource($payout);

        return $this->successResponse(message: 'Success! Transaction list.', data: $data);
    }

    public function payoutSave(PayoutRequest $request, int $id)
    {
        $payout = $this->transactionService->savePayout($request->validated(), $id);

        if(!$payout){
            return $this->errorResponse(message: 'Failed! Payout cannot be saved.');
        }

        return $this->successResponse(message: 'Success! Payout saved.');
    }
}
