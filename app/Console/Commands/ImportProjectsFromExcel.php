<?php

namespace App\Console\Commands;

use App\Imports\ProjectImports;
use App\Imports\ProjectPropertyImports;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportProjectsFromExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:projects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Projects data from Excel file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = storage_path('app/public/excel/project_list.xlsx');

        if(!file_exists($filePath)){
            $this->error('File not found');
            return Command::FAILURE;
        }

        Excel::import(new ProjectPropertyImports(), $filePath);

        $this->info( "Project data import completed.");

        return Command::SUCCESS;
    }
}
