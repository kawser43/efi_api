<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayoutResource extends JsonResource
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
            'campaign_name' => $this->campaign?->project_name ?? null,
            'investor_name' => $this->user ? $this->user->first_name .' '. $this->user->last_name : null,
            'investor_email' => $this->user?->email ?? null,
            'reinvestment_status' => $this->reinvestment_status ? 'Yes' : 'No',
            'transaction_date' => $this->transaction_date ? Carbon::parse($this->transaction_date)->format('d.m.Y') : null,
            'currency' => 'IDR',
            'invested_amount_idr' => $this->invested_amount_idr ? number_format($this->invested_amount_idr, 2) : null,
            'roi_percentage' => $this->roi_percentage ?? 0,
            'profit_margin_idr' => $this->profit_margin_idr ?? 0,
            'total_return_after_tax_idr' => $this->total_return_after_tax_idr ? number_format($this->total_return_after_tax_idr, 2) : null,
            'remaining_capital_idr' => $this->remaining_capital_idr ? number_format($this->remaining_capital_idr, 2) : null,
            //'transactions' => $this->transactions ?? [],
        ];
    }
}
