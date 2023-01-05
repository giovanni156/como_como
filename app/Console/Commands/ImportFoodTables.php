<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportFoodTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:foodtables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import food database from .sql file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $files = [
            'database/migrations/food_tables/04-cereals.sql',
            'database/migrations/food_tables/05-legumes.sql',
            'database/migrations/food_tables/06-oleaginous.sql',
            'database/migrations/food_tables/07-vegetables.sql',
            'database/migrations/food_tables/08-roots.sql',
            'database/migrations/food_tables/09-fruits.sql',
            'database/migrations/food_tables/10-meat.sql',
            'database/migrations/food_tables/12-marine.sql',
            'database/migrations/food_tables/14-dairy.sql',
            'database/migrations/food_tables/15-eggs.sql',
            'database/migrations/food_tables/16-fats.sql',
            'database/migrations/food_tables/17-sweets.sql',
            'database/migrations/food_tables/18-processed.sql',
            'database/migrations/food_tables/19-beverages.sql',
            'database/migrations/food_tables/20-others.sql'
        ];

        $this->info('Importing database info');
        collect($files)->each(function ($file) {
            DB::unprepared(file_get_contents($file));
        });
        $this->info('Imported database info');
    }
}
