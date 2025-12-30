<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payout extends Model
{
    protected $fillable = [
        'user_id',
        'deal_id',
        'campaign_id',
        'reinvestment_status',
        'transaction_date',
        'invested_amount_sgd',
        'invested_amount_idr',
        'roi_percentage',
        'profit_margin_idr',
        'estimated_tax_idr',
        'profit_margin_after_tax_idr',
        'agency_fee_percentage',
        'agency_fee_idr',
        'estimated_payout_before_tax_idr',
        'estimated_payout_after_tax_idr',
        'estimated_payout_after_tax_and_agency_fee_idr',
        'remaining_capital_idr',
        'remaining_profit_after_tax_idr',
        'total_return_after_tax_idr',
        'actual_roi_after_tax_percentage',
    ];

    /**
     * Relationship
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
