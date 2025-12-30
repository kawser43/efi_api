<?php

namespace App\Imports;

use App\Models\Campaign;
use App\Models\CampaignPaymentDate;
use App\Models\Payout;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserBilling;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class PayoutImports implements OnEachRow, WithHeadingRow, WithChunkReading
{
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        if (empty($row['project_name'])) {
            return null;
        }

//        Log::info('Payout:', $row);

        $email = trim($row['email'] ?? '');

        $user = empty($email) ? null : User::where('email', $row['email'])->first();

        $userID = null;
        if($user) {
            $userID = $user->id;
        }


        $transactionDate = $this->excelDateToCarbon(trim($row['date'] ?? ''));

        $payout = Payout::create([
            'user_id' => $userID,
            'deal_id' => $this->getNumericValue(trim($row['deal_id'] ?? '')),
            'campaign_id' => $this->getNumericValue(trim($row['project_id'] ?? '')),
            'reinvestment_status' => $this->getBooleanValue(trim($row['reinvest'] ?? '')),
            'transaction_date' => $transactionDate,
            'invested_amount_sgd' => $this->getNumericValue(trim($row['capital_invested_sgd'] ?? '')),
            'invested_amount_idr' => $this->getNumericValue(trim($row['capital_received_idr'] ?? '')),
            'roi_percentage' => $this->getNumericValue(trim($row['roi'] ?? '')) * 100,
            'profit_margin_idr' => $this->getNumericValue(trim($row['profit_margin_idr'] ?? '')),
            'estimated_tax_idr' => $this->getNumericValue(trim($row['estimated_tax'] ?? '')),
            'profit_margin_after_tax_idr' => $this->getNumericValue(trim($row['profit_margin_after_tax_idr'] ?? '')),
            'agency_fee_percentage' => $this->getNumericValue(trim($row['agency_fee'] ?? '')) * 100,
            'agency_fee_idr' => $this->getNumericValue(trim($row['agency_fee_idr'] ?? '')),
            'estimated_payout_before_tax_idr' => $this->getNumericValue(trim($row['estimated_payout_before_tax_90_capital_idr'] ?? '')),
            'estimated_payout_after_tax_idr' => $this->getNumericValue(trim($row['estimated_payout_after_tax_idr'] ?? '')),
            'estimated_payout_after_tax_and_agency_fee_idr' => $this->getNumericValue(trim($row['estimated_payout_after_tax_agency_fee_idr'] ?? '')),
            'remaining_capital_idr' => $this->getNumericValue(trim($row['remaining_capital'] ?? '')),
            'remaining_profit_after_tax_idr' => $this->getNumericValue(trim($row['remaining_profit_after_tax'] ?? '')),
            'total_return_after_tax_idr' => $this->getNumericValue(trim($row['total_return_after_tax'] ?? '')),
            'actual_roi_after_tax_percentage' => $this->getNumericValue(trim($row['actual_roi_after_tax'] ?? '')) * 100,
        ]);

        $payout->refresh();

        $this->saveTransactions($payout, $row);

    }

    private function saveTransactions($payout, $row)
    {
        $payoutDate1 = $this->excelDateToCarbon(trim($row['1st_payout_date'] ?? ''));
        $payoutDate2 = $this->excelDateToCarbon(trim($row['2nd_payout_date'] ?? ''));

        $firstPartialPayout = new Transaction([
            'capital' => $this->getNumericValue(trim($row['1st_capital_idr'] ?? '')),
            'tax' => $this->getBooleanValue(trim($row['1st_tax_idr'] ?? '')),
            'partial' => $this->getNumericValue(trim($row['1st_partial_idr'] ?? '')),
            'profit' => $this->getNumericValue(trim($row['1st_profit_idr'] ?? '')),
            'available_amount_after_tax' => $this->getNumericValue(trim($row['1st_available_amount_after_tax_idr'] ?? '')),
            'payout_actual' => $this->getNumericValue(trim($row['1st_payout_actual_idr'] ?? '')),
            'currency' => "IDR",
            'payout_actual_transfer' => $this->getNumericValue(trim($row['1st_payout_actual'] ?? '')),
            'transfer_currency' => strtoupper(trim($row['1st_payout_currency'] ?? '')),
            'exchange_rate' => $this->getNumericValue(trim($row['1st_exchange_rate'] ?? '')),
            'payout_status' => trim($row['1st_payout_status'] ?? ''),
            'purpose' => trim($row['1st_purpose'] ?? ''),
            'payout_date' => $payoutDate1,
            'platform' => trim($row['1st_platform'] ?? ''),
            'investment_status' => trim($row['1st_investment_status'] ?? ''),
        ]);

        $secondPartialPayout = new Transaction([
            'capital' => $this->getNumericValue(trim($row['2nd_capital_idr'] ?? '')),
            'tax' => $this->getBooleanValue(trim($row['2nd_tax_idr'] ?? '')),
            'partial' => $this->getNumericValue(trim($row['2nd_partial_idr'] ?? '')),
            'profit' => $this->getNumericValue(trim($row['2nd_profit_idr'] ?? '')),
            'available_amount_after_tax' => $this->getNumericValue(trim($row['2nd_available_amount_after_tax_idr'] ?? '')),
            'payout_actual' => $this->getNumericValue(trim($row['2nd_payout_actual_idr'] ?? '')),
            'currency' => "IDR",
            'payout_actual_transfer' => $this->getNumericValue(trim($row['2nd_payout_actual'] ?? '')),
            'transfer_currency' => strtoupper(trim($row['2nd_payout_currency'] ?? '')),
            'exchange_rate' => $this->getNumericValue(trim($row['2nd_exchange_rate'] ?? '')),
            'payout_status' => trim($row['2nd_payout_status'] ?? ''),
            'purpose' => trim($row['2nd_purpose'] ?? ''),
            'payout_date' => $payoutDate2,
            'platform' => trim($row['2nd_platform'] ?? ''),
            'investment_status' => trim($row['2nd_investment_status'] ?? ''),
        ]);

        $payout->transactions()->saveMany([$firstPartialPayout, $secondPartialPayout]);
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
        if (!$value) return 0;

        if (strtoupper($value) === 'YES') return 1;

        return 0;
    }

    private function getNumericValue($value)
    {
        if (empty($value)) return 0;

        if (!is_numeric($value)) return 0;

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