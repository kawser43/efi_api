<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    protected $fillable = [
        'project_name',
        'number_of_transactions',
        'crowdfunded_amount_sgd',
        'crowdfunded_amount_idr',
        'project_commencement',
        'projected_roi',
        'actual_roi',
        'projected_roi_percentage',
        'actual_roi_percentage',
        'due_date',
        'payout_date',
        'payment_status',
        'payout_status_percentage',
        'project_status',
        'actual_payout_idr',
        'agency_fee_idr',
        'tax_idr',
        'withdrawn_idr',
        'reinvested_idr',
        'available_idr',
        'payout_process',
        'payment_date',
        'remarks',
    ];

    /**
     * Relationship
     */
    public function campaignPaymentDates(): HasMany
    {
        return $this->hasMany(CampaignPaymentDate::class, 'campaign_id');
    }
}
