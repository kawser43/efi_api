<?php

namespace App\Imports;

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

class UserProfileImports implements OnEachRow, WithHeadingRow, WithChunkReading
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

        $customerDate = $this->excelDateToCarbon(trim($row['customer_date'] ?? ''));
        $kycSubmittedAt = $this->excelDateToCarbon(trim($row['kyc_submission_date'] ?? ''));
        $kycVerifiedAt = $this->excelDateToCarbon(trim($row['kyc_verified_date'] ?? ''));
        $kycCheckedAt = $this->excelDateToCarbon(trim($row['kyc_check_date'] ?? ''));
        $passportExpiryDate = $this->excelDateToCarbon(trim($row['passport_expiry_date'] ?? ''));

        $userProfile = new UserProfile([
            'city' => trim($row['city'] ?? ''),
            'city_2' => trim($row['city_2'] ?? ''),
            'state' => trim($row['stateregion'] ?? ''),
            'country' => trim($row['countryregion'] ?? ''),
            'country_2' => trim($row['countryregion_2'] ?? ''),
            'nationality' => trim($row['nationality_obsolete_dt_27821_replaced_by_country_of_passport'] ?? ''),
            'registration_country' => trim($row['country_of_registration'] ?? ''),
            'passport_country' => trim($row['country_of_passport_for_kyc_new_aug_21'] ?? ''),
            'passport_country_no_us_israel' => trim($row['country_of_passport_less_usisrael'] ?? ''),
            'residence_country' => trim($row['country_of_residence'] ?? ''),
            'residence_country_new' => trim($row['country_of_residence_new_dropdown_list'] ?? ''),
            'residence_country_no_israel' => trim($row['country_of_residence_less_israel'] ?? ''),
            'residence_country_no_us_israel' => trim($row['country_of_residence_less_usisrael'] ?? ''),
            'occupation' => trim($row['occupation'] ?? ''),
            'street_address' => trim($row['street_address'] ?? ''),
            'street_address_1' => trim($row['street_address_1'] ?? ''),
            'street_address_2' => trim($row['street_address_2'] ?? ''),
            'home_address' => trim($row['home_address'] ?? ''),
//            'address_line' => trim($row['address_line'] ?? ''),
            'bank_address' => trim($row['bank_address'] ?? ''),
            'postal_code' => trim($row['postal_code'] ?? ''),
            'address_verification_proof' => trim($row['address_verification_proof'] ?? ''),
            'about_you' => trim($row['about_you'] ?? ''),
            'customer_date' => $customerDate,
            'swap_investment_to' => trim($row['i_want_to_swap_my_investment_from_csi_to'] ?? ''),
            'new_email' => trim($row['new_email'] ?? ''),
            't_and_c' => $this->getBooleanValue(trim($row['tc'])),
            'passport_number' => trim($row['passportid_number'] ?? ''),
            'passport_expiry_date' => $passportExpiryDate,
            'is_kyc_submitted_by_investor' => $this->getBooleanValue(trim($row['kyc_form_submitted_by_investor'])),
            'namescan_id' => trim($row['namescan_id'] ?? ''),
            'kyc_submitted_at' => $kycSubmittedAt,
            'kyc_verified_at' => $kycVerifiedAt,
            'kyc_checked_at' => $kycCheckedAt,
//            'rejection_reason' => trim($row['rejection_reason'] ?? ''),
            'id_passport_proof' => trim($row['idpassport_file'] ?? ''),
            'industry' => trim($row['industry'] ?? ''),
            'job_title' => trim($row['job_title'] ?? ''),
        ]);

        $user->userProfile()->save($userProfile);

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