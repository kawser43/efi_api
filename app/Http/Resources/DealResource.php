<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
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
            'deal_record_id' => $this->deal_record_id,
            'deal_name' => $this->deal_name,
            'amount_sgd' => $this->amount_sgd,
            'amount_idr' => $this->amount_idr,
            'profit_idr' => $this->profit_idr,
            'weighted_amount' => $this->weighted_amount,
            'weighted_amount_company_currency' => $this->weighted_amount_company_currency,
            'investor_name_at_transaction' => $this->investor_name_at_transaction,
            'associated_contact' => $this->associated_contact,
            'deal_created_at' => $this->deal_created_at,
            'deal_close_at' => $this->deal_close_at,
        ];
    }
}
