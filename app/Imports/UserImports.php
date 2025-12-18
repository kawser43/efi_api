<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class UserImports implements OnEachRow, WithHeadingRow, WithChunkReading
{
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        if (empty($row['email'])) {
            return null;
        }

        $lastEngagementDate = $this->excelDateToCarbon(trim($row['last_engagement_date'] ?? ''));
        $lastActivityDate = $this->excelDateToCarbon(trim($row['last_activity_date'] ?? ''));
        $becomeInvestorAt = $this->excelDateToCarbon(trim($row['became_a_customer_date_fixed'] ?? ''));
        $closeDate = $this->excelDateToCarbon(trim($row['close_date'] ?? ''));
        $lastModifiedDate = $this->excelDateToCarbon(trim($row['last_modified_date'] ?? ''));
        $createDate = $this->excelDateToCarbon(trim($row['create_date'] ?? ''));
        $dob = $this->excelDateToCarbon(trim($row['date_of_birth'] ?? ''));

        User::create([
            'record_id' => trim($row['record_id_contact'] ?? ''),
            'first_name' => trim($row['first_name'] ?? ''),
            'last_name' => trim($row['last_name'] ?? ''),
            'email' => trim($row['email'] ?? ''),
            'email_verified_at' => now()->format('Y-m-d H:i:s'),
            'password' => Hash::make('12345678'),
            'phone' => trim($row['phone_number'] ?? ''),
            'whatsapp_phone_number' => trim($row['whats_app_number'] ?? ''),
            'date_of_birth' => $dob,
            'gender' => trim($row['gender'] ?? ''),
            'become_investor_at' => $becomeInvestorAt,
            'close_date' => $closeDate,
            'days_to_close' => is_numeric(trim($row['days_to_close'] ?? '')) ? trim($row['days_to_close']) : null,
            'is_unworked' => $this->getBooleanValue(trim($row['contact_unworked'] ?? '')),
            'kyc_status' => trim($row['namescankycresult'] ?? ''),
            'kyc_staus_em' => trim($row['kyc_check_result_em'] ?? ''),
            'kyc_staus_ex' => trim($row['kyc_check_result_ex'] ?? ''),
            'entity' => trim($row['entity'] ?? ''),
            'investor_type' => trim($row['type_of_investor'] ?? ''),
            'membership_type' => trim($row['type_of_membership_em_new_from_laravel'] ?? ''),
            'currency' => trim($row['currency'] ?? ''),
            'contact_owner' => trim($row['contact_owner'] ?? ''),
            'email_preference' => trim($row['email_preference'] ?? ''),

            'ethis_eg' => $this->getBooleanValue(trim($row['ethis_eg'] ?? '')),
            'ethis_global' => $this->getBooleanValue(trim($row['ethis_global'] ?? '')),
            'ethis_my_investor' => $this->getBooleanValue(trim($row['ethis_my_investors'] ?? '')),
            'ethis_ae' => $this->getBooleanValue(trim($row['ethis_ae'] ?? '')),
            'ethis_id' => $this->getBooleanValue(trim($row['ethis_id'] ?? '')),
            'ethis_my' => $this->getBooleanValue(trim($row['ethis_my'] ?? '')),
            'ethis_x' => $this->getBooleanValue(trim($row['ethis_x'] ?? '')),
            'gs' => $this->getBooleanValue(trim($row['globalsadaqahcom'] ?? '')),
            'last_engaged_at' => $lastEngagementDate,
            'last_activity' => $lastActivityDate,
            'last_modified_at' => $lastModifiedDate,
            'updated_by' => trim($row['updated_by_user_id'] ?? ''),
            'create_date' => $createDate
        ]);

    }

    public function chunkSize(): int
    {
        return 200;
    }

    private function getBooleanValue($value): int
    {
        if(!$value) return 0;

        if(strtoupper($value) === 'TRUE') return 1;

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