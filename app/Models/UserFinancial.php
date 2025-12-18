<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFinancial extends Model
{
    protected $fillable = [
        'invest_amount_sgd',
        'total_investment_amount',
        'total_returned_amount',
        'total_revenue',
        'total_money_raised',
        'open_deal_value',
        'closed_deal_value',
        'roi_percentage',
        'last_invested_at',
        'recent_deal_amount',
        'recent_deal_date',
        'investment_through_em',
        'number_of_investment_em',
        'number_of_investment_ex',
        'number_of_investment_ei_global',
        'total_invested_through_ei_global_sgd',
        'total_amount_reinvested_through_ei_global_sgd',
        'total_new_amount_invested_through_ei_global_sgd',
        'total_invested_through_em_myr',
        'total_invested_through_ex_usd',
        'total_investment_in_delayed_projects',
        'total_payout_for_ethis_fund_idr',
        'total_payout_for_ethis_fund_usd',
        'annual_revenue',
    ];
}
