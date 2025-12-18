<?php

namespace App\Imports;

use App\Models\User;
use App\Models\UserBilling;
use App\Models\UserCompany;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class UserCompanyImports implements OnEachRow, WithHeadingRow, WithChunkReading
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

        $dateOfIncorporationOfCompany = $this->excelDateToCarbon(trim($row['date_of_incorporation_of_company'] ?? ''));
        $recordIdCompany = trim($row['record_id_company'] ?? '');

        $userCompany = new UserCompany([
            'record_id_company' => is_numeric($recordIdCompany) ? $recordIdCompany : null,
            'company_name' => trim($row['company_name'] ?? ''),
            'country_of_registration' => trim($row['country_of_registration'] ?? ''),
            'registration_number' => trim($row['company_registration_number'] ?? ''),
            'incorporation_date' => $dateOfIncorporationOfCompany,
            'incorporation_certificate' => trim($row['company_incorporation_certificate'] ?? ''),
            'company_investor_declaration' => $this->getBooleanValue(trim($row['declaration_for_company_investors'] ?? '')),
            'business_type' => trim($row['nature_of_businessindustry'] ?? ''),
            'designation' => trim($row['designation'] ?? ''),
//            'number_of_directors' => trim($row['number_of_directors'] ?? ''),
//            'number_of_shareholders' => trim($row['number_of_shareholders'] ?? ''),
            'name_of_employer' => trim($row['name_of_employer_or_nature_of_self_employment_nature_of_business'] ?? ''),
            'occupation' => trim($row['occupation'] ?? ''),
            'place_of_incorporation' => trim($row['place_of_incorporation'] ?? ''),
            'company_domain' => trim($row['company_domain_name'] ?? ''),
            'company_owner' => trim($row['company_owner'] ?? ''),
        ]);

        $user->userCompany()->save($userCompany);

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