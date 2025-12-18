<?php

namespace App\Imports;

use App\Models\User;
use App\Models\UserBilling;
use App\Models\UserMeta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class UserMetaImports implements OnEachRow, WithHeadingRow, WithChunkReading
{
    private array $controlledColumns = [
        'record_id_contact',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'whats_app_number',
        'gender',
        'date_of_birth',
        'days_to_close',
        'contact_unworked',
        'namescankycresult',
        'kyc_check_result_em',
        'kyc_check_result_ex',
        'entity',
        'type_of_investor',
        'type_of_membership_em_new_from_laravel',
        'currency',
        'contact_owner',
        'email_preference',
        'ethis_eg',
        'ethis_global',
        'ethis_my_investors',
        'ethis_ae',
        'ethis_id',
        'ethis_my',
        'ethis_x',
        'globalsadaqahcom',
        'updated_by_user_id',
        'last_engagement_date',
        'last_activity_date',
        'became_a_customer_date_fixed',
        'close_date',
        'last_modified_date',
        'create_date',

        'customer_date',
        'kyc_submission_date',
        'kyc_verified_date',
        'kyc_check_date',
        'passport_expiry_date',
        'city',
        'city_2',
        'stateregion',
        'countryregion',
        'countryregion_2',
        'nationality_obsolete_dt_27821_replaced_by_country_of_passport',
        'country_of_registration',
        'country_of_passport_for_kyc_new_aug_21',
        'country_of_passport_less_usisrael',
        'country_of_residence',
        'country_of_residence_new_dropdown_list',
        'country_of_residence_less_israel',
        'country_of_residence_less_usisrael',
        'occupation',
        'street_address',
        'street_address_1',
        'street_address_2',
        'home_address',
        'bank_address',
        'postal_code',
        'address_verification_proof',
        'about_you',
        'i_want_to_swap_my_investment_from_csi_to',
        'new_email',
        'tc',
        'passportid_number',
        'kyc_form_submitted_by_investor',
        'namescan_id',
        'idpassport_file',
        'industry',
        'job_title',

        'date_of_incorporation_of_company',
        'record_id_company',
        'company_name',
        'country_of_registration',
        'company_registration_number',
        'company_incorporation_certificate',
        'declaration_for_company_investors',
        'nature_of_businessindustry',
        'designation',
        'name_of_employer_or_nature_of_self_employment_nature_of_business',
        'occupation',
        'place_of_incorporation',
        'company_domain_name',
        'company_owner',

        'billing_address_line_1',
        'billing_city',
        'billing_country',
        'billing_state',
        'account_country',
        'account_name',
        'account_type',
        'bank_address',
        'bank_name',
        'iban',
        'branch',
        'no_change_in_bank_details',
        'preferred_currency_for_payout',

        'recent_deal_close_date',
        'invest_amount_sgd',
        'total_revenue',
        'total_money_raised',
        'total_open_deal_value',
        'recent_deal_amount',
        'total_invested_through_em_myr',
        'total_invested_through_ex_usd',
        'number_of_investments_in_em',
        'number_of_investments_in_ex',
        'number_of_investments_ei_global',
        'total_invested_through_ei_global_sgd',
        'total_amount_reinvested_through_ei_global_sgd',
        'total_new_amount_invested_through_ei_global_sgd',
        'total_investment_in_delayed_projects',
        'total_payout_for_ethis_fund_in_idr',
        'total_payout_for_ethis_fund_in_usd',
        'annual_revenue'
    ];
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        $recordID = trim($row['record_id_contact'] ?? '');

        $user = User::where('record_id', $recordID)->first();

        if (!$user) {
            return null;
        }

        $userMetas = [];

        foreach ($row as $i => $value) {
            $key = trim($i);

            if(in_array($key, $this->controlledColumns)) {
                continue;
            }

            if(empty(trim($value))) {
                continue;
            }

            $userMetas[] = new UserMeta( ['meta_key' => $key, 'meta_value' => trim($value ?? '') ] );
        }

        $user->userMeta()->saveMany($userMetas);
    }

    public function chunkSize(): int
    {
        return 200;
    }




}