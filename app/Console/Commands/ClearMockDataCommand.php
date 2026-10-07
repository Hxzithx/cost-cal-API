<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearMockDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-mock-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all mock dishes, ingredients, batches, logs and operational records to prepare for manual testing';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Clearing operational mock data while preserving master reference tables (units, conversions, categories, suppliers, locations, settings)...');

        Schema::disableForeignKeyConstraints();

        $tables = [
            'dish_ingredient',
            'labor_costs',
            'overhead_costs',
            'dishes',
            'stock_movements',
            'production_logs',
            'pos_daily_sales',
            'grn_batches',
            'grn_records',
            'ingredients',
            'store_locations',
            'departments',
            'suppliers',
            'categories',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->line("  ✓ Cleared table: {$table}");
            }
        }

        Schema::enableForeignKeyConstraints();

        $this->info('All mock operational data removed successfully. System is in clean-slate state!');
        return Command::SUCCESS;
    }
}
