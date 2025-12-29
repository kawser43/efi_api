<?php

namespace App\Console\Commands;

use App\Imports\PayoutImports;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportPayoutsFromExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:payouts {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import payout data from Excel file';

    private array $filePaths = [
        'dv1' => 'app/public/excel/dharman_villas.csv',
        'dv2' => 'app/public/excel/dharman_villas_2.csv',
        'gip' => 'app/public/excel/global_indo_property.xlsx',
        'gis22' => 'app/public/excel/global_indo_sme_2022.xlsx',
        'gis21' => 'app/public/excel/global_indo_sme_2021.xlsx',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $arg = $this->argument('type') ?? null;

        if(is_null($arg)){
            $this->error('Argument not provided');
            return Command::FAILURE;
        }
        $filePath = storage_path($this->filePaths[$arg]);

        if(!file_exists($filePath)){
            $this->error('File not found');
            return Command::FAILURE;
        }

        Excel::import(new PayoutImports(), $filePath);

        $this->info( "Payout data import completed.");

        return Command::SUCCESS;
    }
}
