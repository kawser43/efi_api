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

        Log::info('===Property===', $row);

//        $customerDate = $this->excelDateToCarbon(trim($row['customer_date'] ?? ''));

       /* Campaign::create([
            'city' => trim($row['city'] ?? ''),
        ]);*/
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