<?php

namespace App\Imports;

use App\Models\User;
use App\Models\UserBilling;
use App\Models\UserCompany;
use App\Models\UserFinancial;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class UserFinancialImports implements OnEachRow, WithHeadingRow, WithChunkReading
{
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        if (empty($row['email'])) {
            return null;
        }

        $recordID = trim($row['record_id_contact'] ?? '');

        $user = User::where('record_id', $recordID)->first();

        if(!$user) {
            return null;
        }

        $recentDealCloseDate = $this->excelDateToCarbon(trim($row['recent_deal_close_date'] ?? ''));
//        $recordIdCompany = trim($row['record_id_company'] ?? '');

        $userFinancial = new UserFinancial([
            'invest_amount_sgd' => $this->getNumericValue(trim($row['invest_amount_sgd'] ?? '')),
            'total_revenue' => $this->getNumericValue(trim($row['total_revenue'] ?? '')),
            'total_money_raised' => $this->getNumericValue(trim($row['total_money_raised'] ?? '')),
            'open_deal_value' => $this->getNumericValue(trim($row['total_open_deal_value'] ?? '')),
            'recent_deal_amount' => $this->getNumericValue(trim($row['recent_deal_amount'] ?? '')),
            'recent_deal_date' => $recentDealCloseDate,
            'total_invested_through_em_myr' => $this->getNumericValue(trim($row['total_invested_through_em_myr'] ?? '')),
            'total_invested_through_ex_usd' => $this->getNumericValue(trim($row['total_invested_through_ex_usd'] ?? '')),
            'number_of_investment_em' => $this->getNumericValue(trim($row['number_of_investments_in_em'] ?? '')),
            'number_of_investment_ex' => $this->getNumericValue(trim($row['number_of_investments_in_ex'] ?? '')),
            'number_of_investment_ei_global' => $this->getNumericValue(trim($row['number_of_investments_ei_global'] ?? '')),
            'total_invested_through_ei_global_sgd' => $this->getNumericValue(trim($row['total_invested_through_ei_global_sgd'] ?? '')),
            'total_amount_reinvested_through_ei_global_sgd' => $this->getNumericValue(trim($row['total_amount_reinvested_through_ei_global_sgd'] ?? '')),
            'total_new_amount_invested_through_ei_global_sgd' => $this->getNumericValue(trim($row['total_new_amount_invested_through_ei_global_sgd'] ?? '')),
            'total_investment_in_delayed_projects' => $this->getNumericValue(trim($row['total_investment_in_delayed_projects'] ?? '')),
            'total_payout_for_ethis_fund_idr' => $this->getNumericValue(trim($row['total_payout_for_ethis_fund_in_idr'] ?? '')),
            'total_payout_for_ethis_fund_usd' => $this->getNumericValue(trim($row['total_payout_for_ethis_fund_in_usd'] ?? '')),
            'annual_revenue' => $this->getNumericValue(trim($row['annual_revenue'] ?? '')),
        ]);

        $user->userFinancial()->save($userFinancial);

    }

    public function chunkSize(): int
    {
        return 200;
    }

    private function getBooleanValue($value): int
    {
        if(!$value) return 0;

        if(strtoupper($value) === 'YES') return 1;

        return 0;
    }

    private function excelDateToCarbon($value): ?Carbon
    {
        if (empty($value)) {
            return null;
        }

        // If it's numeric → Excel serial date
        if (is_numeric($value)) {
            return Carbon::instance(
                ExcelDate::excelToDateTimeObject($value)
            );
        }

        // If it's string → try normal parsing
        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getNumericValue($value)
    {
        if(empty($value)) return null;

        if(!is_numeric($value)) return null;

        return $value;
    }



}