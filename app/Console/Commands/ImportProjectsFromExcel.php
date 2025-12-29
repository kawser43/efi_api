<?php

namespace App\Console\Commands;

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
    protected $signature = 'import:projects {type? : Import type (property, 2021, 2022)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Projects data from Excel file';

    private array $filePaths = [
        'property' => 'app/public/excel/project_property.xlsx',
        '2021' => 'app/public/excel/project_2021.xlsx',
        '2022' => 'app/public/excel/project_2022.xlsx',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $arg = $this->argument('type') ?? 'property';
        $filePath = storage_path($this->filePaths[$arg]);

        if(!file_exists($filePath)){
            $this->error('File not found');
            return Command::FAILURE;
        }

        Excel::import(new ProjectPropertyImports(), $filePath);

        $this->info( "Project data import completed.");

        return Command::SUCCESS;
    }
}
