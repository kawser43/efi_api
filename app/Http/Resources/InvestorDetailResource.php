<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class InvestorDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $users = $this->parseUserTableData();
        $profile = $this->parseProfileTableData();
        $financial = $this->parseFinancialTableData();
        $company = $this->parseCompayTableData();
        //$metaData = $this->parseMetaTableData();

        $allData = array_merge($users, $profile, $financial, $company);
        $pairedAttrData = [];

        foreach ($allData as $key => $value) {
            $pairedAttrData[] = [
                'key' => Str::headline($key),
                'value' => $value,
            ];
        }

        return $pairedAttrData;
    }

    private function parseUserTableData()
    {
        return [
            "record_id" => $this->record_id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "phone" => $this->phone,
            "whatsapp_phone_number" => $this->whatsapp_phone_number,
            "date_of_birth" => $this->date_of_birth ? Carbon::parse($this->date_of_birth)->format('d.m.Y') : null,
            "gender" => $this->gender,
            "become_investor_at" => $this->become_investor_at ? Carbon::parse($this->become_investor_at)->format('d.m.Y') : null,
            "close_date" => $this->close_date,
            "days_to_close" => $this->days_to_close,
            "is_unworked" => $this->is_unworked ? 'Yes' : 'No',
            "kyc_status" => $this->kyc_status,
            "kyc_staus_em" => $this->kyc_staus_em,
            "kyc_staus_ex" => $this->kyc_staus_ex,
            "entity" => $this->entity,
            "investor_type" => $this->investor_type,
            "membership_type" => $this->membership_type,
            "currency" => $this->currency,
            "contact_owner" => $this->contact_owner,
            "email_preference" => $this->email_preference,
            "ethis_eg" => $this->ethis_eg,
            "ethis_global" => $this->ethis_global,
            "ethis_my_investor" => $this->ethis_my_investor,
            "ethis_ae" => $this->ethis_ae,
            "ethis_id" => $this->ethis_id,
            "ethis_my" => $this->ethis_my,
            "ethis_x" => $this->ethis_x,
            "gs" => $this->gs,
            "last_engaged_at" => $this->last_engaged_at ? Carbon::parse($this->last_engaged_at)->format('d.m.Y') : null,
            "last_activity" => $this->last_activity,
            "last_modified_at" => $this->last_modified_at ? Carbon::parse($this->last_modified_at)->format('d.m.Y') : null,
            "updated_by" => $this->updated_by,
            "create_date" => $this->create_date ? Carbon::parse($this->create_date)->format('d.m.Y') : null,
        ];
    }

    private function parseBillingTableData()
    {
        if(!$this->userBilling) return [];

        return [
            "billing_address" => $this->userBilling->billing_address,
            "billing_city" => $this->userBilling->billing_city,
            "billing_country" => $this->userBilling->billing_country,
            "billing_state" => $this->userBilling->billing_state,
            "account_country" => $this->userBilling->account_country,
            "account_name" => $this->userBilling->account_name,
            "account_type" => $this->userBilling->account_type,
            "bank_address" => $this->userBilling->bank_address,
            "bank_name" => $this->userBilling->bank_name,
            "iban" => $this->userBilling->iban,
            "bank_branch" => $this->userBilling->bank_branch,
            "has_no_change" => $this->userBilling->has_no_change,
            "payout_currency" => $this->userBilling->payout_currency,
        ];
    }

    private function parseProfileTableData()
    {
        if(!$this->userProfile) return [];

        return [
            "city" => $this->userProfile->city,
            "city_2" => $this->userProfile->city_2,
            "state" => $this->userProfile->state,
            "country" => $this->userProfile->country,
            "country_2" => $this->userProfile->country_2,
            "nationality" => $this->userProfile->nationality,
            "registration_country" => $this->userProfile->registration_country,
            "passport_country" => $this->userProfile->passport_country,
            "passport_country_no_us_israel" => $this->userProfile->passport_country_no_us_israel,
            "residence_country" => $this->userProfile->residence_country,
            "residence_country_new" => $this->userProfile->residence_country_new,
            "residence_country_no_israel" => $this->userProfile->residence_country_no_israel,
            "residence_country_no_us_israel" => $this->userProfile->residence_country_no_us_israel,
            "occupation" => $this->userProfile->occupation,
            "street_address" => $this->userProfile->street_address,
            "street_address_1" => $this->userProfile->street_address_1,
            "street_address_2" => $this->userProfile->street_address_2,
            "home_address" => $this->userProfile->home_address,
            "address_line" => $this->userProfile->address_line,
            "bank_address" => $this->userProfile->bank_address,
            "postal_code" => $this->userProfile->postal_code,
            "address_verification_proof" => $this->userProfile->address_verification_proof,
            "about_you" => $this->userProfile->about_you,
            "customer_date" => $this->userProfile->customer_date,
            "swap_investment_to" => $this->userProfile->swap_investment_to,
            "new_email" => $this->userProfile->new_email,
            "t_and_c" => $this->userProfile->t_and_c,
            "passport_number" => $this->userProfile->passport_number,
            "passport_expiry_date" => $this->userProfile->passport_expiry_date,
            "is_kyc_submitted_by_investor" => $this->userProfile->is_kyc_submitted_by_investor,
            "namescan_id" => $this->userProfile->namescan_id,
            "kyc_submitted_at" => $this->userProfile->kyc_submitted_at,
            "kyc_verified_at" => $this->userProfile->kyc_verified_at,
            "kyc_checked_at" => $this->userProfile->kyc_checked_at,
            "rejection_reason" => $this->userProfile->rejection_reason,
            "id_passport_proof" => $this->userProfile->id_passport_proof,
            "industry" => $this->userProfile->industry,
            "job_title" => $this->userProfile->job_title,
        ];
    }

    private function parseCompayTableData()
    {
        if (!$this->userCompany) return [];

        return [
            "record_id_company" => $this->userCompany->record_id_company,
            "company_name" => $this->userCompany->company_name,
            "country_of_registration" => $this->userCompany->country_of_registration,
            "registration_number" => $this->userCompany->registration_number,
            "incorporation_date" => $this->userCompany->incorporation_date,
            "incorporation_certificate" => $this->userCompany->incorporation_certificate,
            "company_investor_declaration" => $this->userCompany->company_investor_declaration,
            "business_type" => $this->userCompany->business_type,
            "designation" => $this->userCompany->designation,
            "number_of_directors" => $this->userCompany->number_of_directors,
            "number_of_shareholders" => $this->userCompany->number_of_shareholders,
            "name_of_employer" => $this->userCompany->name_of_employer,
            "occupation" => $this->userCompany->occupation,
            "place_of_incorporation" => $this->userCompany->place_of_incorporation,
            "company_domain" => $this->userCompany->company_domain,
            "company_owner" => $this->userCompany->company_owner,
        ];
    }

    private function parseFinancialTableData()
    {
        if(!$this->userFinancial) return [];

        return [
            "invest_amount_sgd" => $this->userFinancial->invest_amount_sgd,
            "total_revenue" => $this->userFinancial->total_revenue,
            "total_money_raised" => $this->userFinancial->total_money_raised,
            "open_deal_value" => $this->userFinancial->open_deal_value,
            "recent_deal_amount" => $this->userFinancial->recent_deal_amount,
            "recent_deal_date" => $this->userFinancial->recent_deal_date,
            "number_of_investment_em" => $this->userFinancial->number_of_investment_em,
            "number_of_investment_ex" => $this->userFinancial->number_of_investment_ex,
            "number_of_investment_ei_global" => $this->userFinancial->number_of_investment_ei_global,
            "total_invested_through_ei_global_sgd" => $this->userFinancial->total_invested_through_ei_global_sgd,
            "total_amount_reinvested_through_ei_global_sgd" => $this->userFinancial->total_amount_reinvested_through_ei_global_sgd,
            "total_new_amount_invested_through_ei_global_sgd" => $this->userFinancial->total_new_amount_invested_through_ei_global_sgd,
            "total_invested_through_em_myr" => $this->userFinancial->total_invested_through_em_myr,
            "total_invested_through_ex_usd" => $this->userFinancial->total_invested_through_ex_usd,
            "total_investment_in_delayed_projects" => $this->userFinancial->total_investment_in_delayed_projects,
            "total_payout_for_ethis_fund_idr" => $this->userFinancial->total_payout_for_ethis_fund_idr,
            "total_payout_for_ethis_fund_usd" => $this->userFinancial->total_payout_for_ethis_fund_usd,
            "annual_revenue" => $this->userFinancial->annual_revenue,
        ];
    }

    private function parseMetaTableData()
    {
        if(!$this->user_meta) return [];

        $metaData = [];

        foreach ($this->user_meta as $meta) {
            $metaData[$meta->meta_key] = $meta->meta_value;
        }

        return $metaData;
    }


}
