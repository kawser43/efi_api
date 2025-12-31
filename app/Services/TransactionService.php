<?php

namespace App\Services;

use App\Models\Deal;
use App\Models\Payout;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function savePayout(array $data, int $id)
    {
        DB::beginTransaction();

        try {
            $payout = Payout::findOrFail($id);

            $transaction = new Transaction();

            // Numeric fields (nullable)
            $transaction->payout_id = $id;
            $transaction->capital = $data['capital'] ?? null;
            $transaction->tax = $data['tax'] ?? null;
            $transaction->partial = $data['partial'] ?? null;
            $transaction->profit = $data['profit'] ?? null;
            $transaction->available_amount_after_tax = $data['available_amount_after_tax'] ?? null;
            $transaction->payout_actual = $data['payout_actual'] ?? null;
            $transaction->payout_actual_transfer = $data['payout_actual_transfer'] ?? null;
            $transaction->exchange_rate = $data['exchange_rate'] ?? null;

            // Select / string fields
            $transaction->transfer_currency = $data['transfer_currency'] ?? null;
            $transaction->payout_status = $data['payout_status'] ?? null;
            $transaction->investment_status = $data['investment_status'] ?? null;
            $transaction->platform = $data['platform'] ?? null;

            // Other fields
            $transaction->purpose = $data['purpose'] ?? null;
            $transaction->payout_date = $data['payout_date'] ? Carbon::parse($data['payout_date'])->format('Y-m-d H:i:s') : null;

            $transaction->save();

            $payout->remaining_capital_idr = ($payout->remaining_capital_idr ?? 0) + ($data['capital'] ?? 0);
            $payout->total_return_after_tax_idr = ($payout->total_return_after_tax_idr ?? 0) + ( $data['capital'] ?? 0);

            $payout->save();

            DB::commit();
            return $transaction;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}