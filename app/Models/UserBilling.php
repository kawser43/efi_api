<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBilling extends Model
{
    protected $fillable = [
        'billing_address',
        'billing_city',
        'billing_country',
        'billing_state',
        'account_country',
        'account_name',
        'account_type',
        'bank_address',
        'bank_name',
        'iban',
        'bank_branch',
        'has_no_change',
        'payout_currency',
    ];
}
