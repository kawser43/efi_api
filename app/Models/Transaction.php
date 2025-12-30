<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'capital',
        'tax',
        'partial',
        'profit',
        'available_amount_after_tax',
        'payout_actual',
        'currency',
        'payout_actual_transfer',
        'transfer_currency',
        'exchange_rate',
        'payout_status',
        'purpose',
        'payout_date',
        'platform',
        'investment_status',
    ];
}
