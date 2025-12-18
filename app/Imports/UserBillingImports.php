<?php

namespace App\Imports;

use App\Models\User;
use App\Models\UserBilling;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class UserBillingImports implements OnEachRow, WithHeadingRow, WithChunkReading
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

        $userBilling = new UserBilling([
            'billing_address' => trim($row['billing_address_line_1'] ?? ''),
            'billing_city' => trim($row['billing_city'] ?? ''),
            'billing_country' => trim($row['billing_country'] ?? ''),
            'billing_state' => trim($row['billing_state'] ?? ''),
            'account_country' => trim($row['account_country'] ?? ''),
            'account_name' => trim($row['account_name'] ?? ''),
            'account_type' => trim($row['account_type'] ?? ''),
            'bank_address' => trim($row['bank_address'] ?? ''),
            'bank_name' => trim($row['bank_name'] ?? ''),
            'iban' => trim($row['iban'] ?? ''),
            'bank_branch' => trim($row['branch'] ?? ''),
            'has_no_change' => $this->getBooleanValue(trim($row['no_change_in_bank_details'] ?? '')),
            'payout_currency' => trim($row['preferred_currency_for_payout'] ?? ''),
        ]);

        $user->userBilling()->save($userBilling);

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



}