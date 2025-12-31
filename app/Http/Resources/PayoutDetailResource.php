<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PayoutDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "deal_id" => $this->deal_id,
            "investor_name" => ($this->user?->first_name .' '. $this->user?->last_name) ?? null,
            "project_name" => $this->campaign->project_name ?? null,
            "reinvestment_status" => $this->reinvestment_status ? 'Yes' : 'No',
            "transaction_date" => $this->transaction_date ? Carbon::parse($this->transaction_date)->format('d.m.Y') : null,
            "invested_amount_sgd" => number_format($this->invested_amount_sgd ?? 0, 2),
            "invested_amount_idr" => number_format($this->invested_amount_idr ?? 0, 2),
            "roi_percentage" => ($this->roi_percentage ?? 0) . '%',
            "profit_margin_idr" => number_format($this->profit_margin_idr ?? 0, 2),
            "estimated_tax_idr" => number_format($this->estimated_tax_idr ?? 0, 2),
            "profit_margin_after_tax_idr" => number_format($this->profit_margin_after_tax_idr ?? 0, 2),
            "agency_fee_percentage" => ($this->agency_fee_percentage ?? 0) . '%',
            "agency_fee_idr" => number_format($this->agency_fee_idr ?? 0, 2),
            "estimated_payout_before_tax_idr" => number_format($this->estimated_payout_before_tax_idr ?? 0, 2),
            "estimated_payout_after_tax_idr" => number_format($this->estimated_payout_after_tax_idr ?? 0, 2),
            "estimated_payout_after_tax_and_agency_fee_idr" => number_format($this->estimated_payout_after_tax_and_agency_fee_idr ?? 0, 2),
            "remaining_capital_idr" => number_format($this->remaining_capital_idr ?? 0, 2),
            "remaining_profit_after_tax_idr" => number_format($this->remaining_profit_after_tax_idr ?? 0, 2),
            "total_return_after_tax_idr" => number_format($this->total_return_after_tax_idr ?? 0, 2),
            "actual_roi_after_tax_percentage" => ($this->actual_roi_after_tax_percentage ?? 0) . '%',

            "transactions" => $this->getTransactions(),
        ];
    }

    private function getTransactions()
    {
        if(!$this->transactions) return null;

        $transactionData = [];
        foreach ($this->transactions as $transaction) {
            $transactionData[] = [
                "id" => $transaction->id,
                "capital" => number_format($transaction->capital ?? 0, 2),
                "tax" => number_format($transaction->tax ?? 0, 2),
                "partial" => number_format($transaction->partial ?? 0, 2),
                "profit" => number_format($transaction->profit ?? 0, 2),
                "available_amount_after_tax" => number_format($transaction->available_amount_after_tax ?? 0, 2),
                "payout_actual" => number_format($transaction->payout_actual ?? 0, 2),
                "currency" => $transaction->currency,
                "payout_actual_transfer" => number_format($transaction->payout_actual_transfer ?? 0, 2),
                "transfer_currency" => $transaction->transfer_currency,
                "exchange_rate" => number_format($transaction->exchange_rate ?? 0, 2),
                "payout_status" => $transaction->payout_status,
                "purpose" => $transaction->purpose,
                "payout_date" => $transaction->payout_date ? Carbon::parse($transaction->payout_date)->format('d.m.Y') : null,
                "platform" => $transaction->platform,
                "investment_status" => $transaction->investment_status,
            ];
        }

        return $transactionData;

    }







}
