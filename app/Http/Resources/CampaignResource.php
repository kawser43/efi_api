<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project_name' => $this->project_name,
            'number_of_transactions' => $this->number_of_transactions,
            'currency' => 'IDR',
            'crowdfunded_amount' => $this->crowdfunded_amount_idr ? 'IDR ' . $this->crowdfunded_amount_idr : null,
            'withdrawn_amount' => $this->withdrawn_idr ? 'IDR ' . $this->withdrawn_idr : null,
            'available_amount' => $this->getAvailableAmount(),
            'payout_process' => $this->getPayoutProcess()
        ];
    }

    private function getAvailableAmount()
    {
        //=N4-Q4-R4-O4-P4 #Formula from excel sheet

        $actualPayout = $this->actual_payout_idr ?? 0;
        $withdrawn = $this->withdrawn_idr ?? 0;
        $reinvested = $this->reinvested_idr ?? 0;
        $agencyFee = $this->agency_fee_idr ?? 0;
        $tax = $this->tax_idr ?? 0;

        $availableAmount  = ($actualPayout - $withdrawn - $reinvested - $agencyFee - $tax);

        if(!$availableAmount) return null;

        $availableAmount = number_format($availableAmount, 2);
        return "IDR " . $availableAmount;
    }

    private function getPayoutProcess()
    {
        //=(R2+Q2+P2+O2)/N2 #Formula from excel sheet

        $reinvested = $this->reinvested_idr ?? 0;
        $withdrawn = $this->withdrawn_idr ?? 0;
        $tax = $this->tax_idr ?? 0;
        $agencyFee = $this->agency_fee_idr ?? 0;
        $actualPayout = $this->actual_payout_idr ?? 0;

        $totalSpent = ($reinvested + $withdrawn + $tax + $agencyFee);

        if(!$actualPayout) return "0%";

        $progress = ($totalSpent/ $actualPayout) * 100;
        return round($progress, 2) . '%';
    }
}
