<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvestorResource extends JsonResource
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
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'become_investor_at' => $this->become_investor_at ? Carbon::parse($this->become_investor_at)->format('d.m.Y') : null,
            'contact_owner' => $this->contact_owner,
            'last_engaged_at' => $this->last_engaged_at ? Carbon::parse($this->last_engaged_at)->format('d.m.Y') : null,
            'platform' => $this->getPlatforms(),
            'is_unworked' => $this->is_unworked ? "Yes" : "No",
        ];
    }

    private function getPlatforms()
    {
        $platforms = [];
        if($this->ethis_id) array_push($platforms, 'Ethis ID');
        if($this->ethis_eg) array_push($platforms, 'Ethis EG');
        if($this->ethis_global) array_push($platforms, 'Ethis Global');
        if($this->ethis_ae) array_push($platforms, 'Ethis AE');
        if($this->ethis_my) array_push($platforms, 'Ethis MY');
        if($this->ethis_x) array_push($platforms, 'EthisX');

        return implode(',', $platforms);
    }
}
