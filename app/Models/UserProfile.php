<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'city',
        'city_2',
        'state',
        'country',
        'country_2',
        'nationality',
        'registration_country',
        'passport_country',
        'passport_country_no_us_israel',
        'residence_country',
        'residence_country_new',
        'residence_country_no_israel',
        'residence_country_no_us_israel',
        'occupation',
        'street_address',
        'street_address_1',
        'street_address_2',
        'home_address',
        'address_line',
        'bank_address',
        'postal_code',
        'address_verification_proof',
        'about_you',
        'customer_date',
        'swap_investment_to',
        'new_email',
        't_and_c',
        'passport_number',
        'passport_expiry_date',
        'is_kyc_submitted_by_investor',
        'namescan_id',
        'kyc_submitted_at',
        'kyc_verified_at',
        'kyc_checked_at',
        'rejection_reason',
        'id_passport_proof',
        'industry',
        'job_title',
    ];
}
