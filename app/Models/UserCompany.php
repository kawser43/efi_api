<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserCompany extends Model
{
    protected $fillable = [
        'record_id_company',
        'company_name',
        'country_of_registration',
        'registration_number',
        'incorporation_date',
        'incorporation_certificate',
        'company_investor_declaration',
        'business_type',
        'designation',
        'number_of_directors',
        'number_of_shareholders',
        'name_of_employer',
        'occupation',
        'place_of_incorporation',
        'company_domain',
        'company_owner',
    ];

    /**
     * Relationship
     */

}
