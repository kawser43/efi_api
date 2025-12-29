<?php

namespace App\Imports;

use App\Models\Campaign;
use App\Models\CampaignPaymentDate;
use App\Models\Deal;
use App\Models\User;
use App\Models\UserBilling;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class DealsImports implements OnEachRow, WithHeadingRow, WithChunkReading
{
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        $user = User::where('record_id', $row['associated_contact_ids'])->first();

        $userID = null;
        if($user) {
            $userID = $user->id;
        }

//        Log::info('Deals:', $row);


//        $createDate = $this->excelDateToCarbon(trim($row['create_date'] ?? ''));
//        $closeDate = $this->excelDateToCarbon(trim($row['close_date'] ?? ''));

        $deals = new Deal;

        $deals->user_id = $userID;
        $deals->associated_contact_id = $this->getNumericValue(trim($row['associated_contact_ids'], ''), true) ?? null;
        $deals->deal_record_id = trim($row['record_id'], '') ?? null;
        $deals->deal_name = trim($row['deal_name'], '') ?? null;
        $deals->pipeline = trim($row['pipeline'], '') ?? null;
        $deals->deal_stage = trim($row['deal_stage'], '') ?? null;
        $deals->amount_sgd = $this->getNumericValue(trim($row['amount_in_sgd'], '')) ?? null;
        $deals->amount_idr = $this->getNumericValue(trim($row['amount_in_idr'], '')) ?? null;
        $deals->profit_idr = $this->getNumericValue(trim($row['profit_idr'], '')) ?? null;
        $deals->weighted_amount = $this->getNumericValue(trim($row['weighted_amount'], '')) ?? null;
        $deals->weighted_amount_company_currency = $this->getNumericValue(trim($row['weighted_amount_in_company_currency'], '')) ?? null;
        $deals->transaction_type = "Deals";
        $deals->investor_name_at_transaction = trim($row['name_of_the_investor'], '') ?? null;
        $deals->associated_contact = trim($row['associated_contact'], '') ?? null;

        $deals->deal_created_at = trim($row['create_date'], '') ?? null;
        $deals->deal_close_at = trim($row['close_date'], '') ?? null;

        $deals->save();
    }

    public function chunkSize(): int
    {
        return 200;
    }

    private function getAvailableAttrValue($attributes, $array)
    {
        foreach ($attributes as $attribute) {
            if (isset($array[$attribute]) && $array[$attribute]) {
                return $array[$attribute];
                break;
            }
        }

        return "";
    }

    private function getBooleanValue($value): int
    {
        if(!$value) return 0;

        if(strtoupper($value) === 'YES') return 1;

        return 0;
    }

    private function getNumericValue($value, $isNullable = false)
    {
        if(empty($value)) return $isNullable ? null :0;

        if(!is_numeric($value)) return $isNullable ? null :0;

        return $value;
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



}