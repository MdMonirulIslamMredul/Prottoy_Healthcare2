<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpzilaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to the SQL file
        $sqlFile = 'c:\\Users\\monir\\Downloads\\Loan_maker\\upzillas.sql';

        if (file_exists($sqlFile)) {
            // Read the SQL file
            $sql = file_get_contents($sqlFile);

            // Extract only the INSERT statements
            preg_match_all('/INSERT INTO `upzillas`.*?VALUES\s*(\(.*?\));/is', $sql, $matches);

            if (!empty($matches[0])) {
                // Disable foreign key checks temporarily
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                foreach ($matches[0] as $insertStatement) {
                    // Replace table name to match our schema
                    $insertStatement = str_replace('`upzillas`', '`upzilas`', $insertStatement);
                    DB::statement($insertStatement);
                }

                // Re-enable foreign key checks
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        } else {
            $this->command->error('Upzilas SQL file not found at: ' . $sqlFile);
            $this->command->info('Please ensure the upzillas.sql file is available.');
        }
    }
}
