<?php

namespace App\Console\Commands;

use App\Imports\DealsImports;
use App\Imports\PayoutImports;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportDealsFromExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:deals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import deals data from Excel file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = storage_path('app/public/excel/deals.csv');

        if(!file_exists($filePath)){
            $this->error('File not found');
            return Command::FAILURE;
        }

        Excel::import(new DealsImports(), $filePath);

        $this->info( "Payout data import completed.");

        return Command::SUCCESS;
    }
}
