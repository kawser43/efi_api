<?php

namespace App\Imports;

use App\Models\Campaign;
use App\Models\CampaignPaymentDate;
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

        if (empty($row['deal_id'])) {
            return null;
        }

        Log::info('Transaction:', $row);

        return null;

//        $projectCommencement = $this->excelDateToCarbon(trim($row['project_commencement'] ?? ''));
//        $dueDate = $this->excelDateToCarbon(trim($row['due_date'] ?? ''));
//        $paymentDateValue = $this->getAvailableAttrValue(['payout_date', 'payment_date_by_the_issuer', 'payment_date'], $row);
//        $paymentDate = $this->excelDateToCarbon(trim($paymentDateValue ?? ''));

        $campaign = Campaign::where(['project_name' => trim($row['project_name'])])->firstOrNew();

        if (!$campaign->id) {
            $campaign->project_name = trim($row['project_name'], '');
            $campaign->number_of_transactions = isset($row['total_transactions']) ? $this->getNumericValue(trim($row['total_transactions'], '')) : null;
            $campaign->crowdfunded_amount_sgd = isset($row['crowdfunded_amount_sgd']) ? $this->getNumericValue(trim($row['crowdfunded_amount_sgd'], '')) : null;
            $campaign->crowdfunded_amount_idr = isset($row['crowdfunded_amount_idr']) ? $this->getNumericValue(trim($row['crowdfunded_amount_idr'], '')) : null;
            $campaign->project_commencement = $projectCommencement;
            $campaign->projected_roi = isset($row['projected_roi']) ? trim($row['projected_roi'], '') ?? null : null;
            $campaign->actual_roi = isset($row['actual_roi']) ? trim($row['actual_roi'], '') ?? null : null;
            $campaign->payment_status = trim($this->getAvailableAttrValue(['payment_status'], $row) ?? '') ?? null;
            $campaign->payout_status_percentage = (isset($row['payout_status']) ? $this->getNumericValue(trim($row['payout_status'], '')) : 0) * 100;
            $campaign->project_status = isset($row['project_status']) ? trim($row['project_status'], '') : null;
            $campaign->actual_payout_idr = isset($row['actual_payout_idr']) ? $this->getNumericValue(trim($row['actual_payout_idr'], '')) : 0;
            $campaign->agency_fee_idr = isset($row['agency_fee_idr']) ? $this->getNumericValue(trim($row['agency_fee_idr'], '')) : 0;
            $campaign->tax_idr = isset($row['tax_idr']) ? $this->getNumericValue(trim($row['tax_idr'], '')) : 0;
            $campaign->withdrawn_idr = isset($row['withdrawn_idr']) ? $this->getNumericValue(trim($row['withdrawn_idr'], '')) : 0;
            $campaign->reinvested_idr = isset($row['reinvested_idr']) ? $this->getNumericValue(trim($row['reinvested_idr'], '')) : 0;
            //$campaign->payout_process = isset($row['payout_process']) ? trim($row['payout_process'], '') : null; //This is formula
            //'payment_date' => $paymentDate,
            //$campaign->remarks = isset($row['remarks']) ? trim($row['remarks'], '') : null; //This is formula

            $campaign->save();
            $campaign->refresh();
        }
        CampaignPaymentDate::create(['campaign_id' => $campaign->id, 'payment_date' => $paymentDate]);
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