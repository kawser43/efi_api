<?php

namespace App\Imports;

use App\Models\Campaign;
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

class ProjectPropertyImports implements OnEachRow, WithHeadingRow, WithChunkReading
{
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        if(empty($row['project_name'])) {
            return null;
        }

        $projectCommencement = $this->excelDateToCarbon(trim($row['project_commencement'] ?? ''));
        $dueDate = $this->excelDateToCarbon(trim($row['due_date'] ?? ''));
        $payoutDate = $this->excelDateToCarbon(trim($row['payout_date'] ?? ''));
        $paymentDate = $this->excelDateToCarbon(trim($row['payment_date'] ?? ''));

        Campaign::updateOrCreate(
            [
                'project_name' => trim($row['project_name'], ''),
            ],
            [
            'number_of_transactions' => trim($row['number_of_transactions'], ''),
            'crowdfunded_amount_sgd' => trim($row['crowdfunded_amount_sgd'], ''),
            'crowdfunded_amount_idr' => trim($row['crowdfunded_amount_idr'], ''),
            'project_commencement' => $projectCommencement,
            'projected_roi_percentage' => trim($row['projected_roi_percentage'], ''),
            'actual_roi_percentage' => trim($row['actual_roi_percentage'], ''),

            'due_date' => $dueDate,
            'payout_date' => $payoutDate,
            'payment_status' => trim($row['payment_status'], ''),
            'payout_status_percentage' => trim($row['payout_status_percentage'], ''),
            'project_status' => trim($row['project_status'], ''),
            'actual_payout_idr' => trim($row['actual_payout_idr'], ''),
            'agency_fee_idr' => trim($row['agency_fee_idr'], ''),
            'tax_idr' => trim($row['tax_idr'], ''),
            'withdrawn_idr' => trim($row['withdrawn_idr'], ''),
            'reinvested_idr' => trim($row['reinvested_idr'], ''),
            'available_idr' => trim($row['available_idr'], ''),
            'payout_process' => trim($row['payout_process'], ''),
            'payment_date' => $paymentDate,
            'remarks' => trim($row['remarks'], ''),
        ]);
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