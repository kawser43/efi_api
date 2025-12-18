<?php

namespace App\Console\Commands;

use App\Imports\UserBillingImports;
use App\Imports\UserCompanyImports;
use App\Imports\UserFinancialImports;
use App\Imports\UserImports;
use App\Imports\UserMetaImports;
use App\Imports\UserProfileImports;
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
    protected $signature = 'import:users {type? : Import type (users, billings, profiles, companies, company_people, financials, metas, transactions)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users data from Excel file';

    protected array $importMap = [
        'users' => UserImports::class,
        'billings' => UserBillingImports::class,
        'profiles' => UserProfileImports::class,
        'companies' => UserCompanyImports::class,
        'financials' => UserFinancialImports::class,
        'metas' => UserMetaImports::class,
    ];

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

        $type = $this->argument('type') ?? 'users';

        if(!array_key_exists($type, $this->importMap)){
            $this->error("Invalid import type: {$type}");
            $this->line('Available types: ' . implode(', ', array_keys($this->importMap)));
            return Command::FAILURE;
        }

        $importClass = $this->importMap[$type];

        Excel::import(new $importClass(), $filePath);

        $this->info( ucfirst($type) . " data import completed.");

        return Command::SUCCESS;

    }
}
