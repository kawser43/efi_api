<?php

namespace App\Console\Commands;

use App\Imports\UserImports;
use App\Models\User;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportUsersFromExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from Excel file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = storage_path('app/public/excel/all_investors.xlsx');

        if(!file_exists($filePath)){
            $this->error('File not found');
            return Command::FAILURE;
        }

        Excel::import(new UserImports(), $filePath);

        $this->info('Users import completed.');

        return Command::SUCCESS;

    }
}
