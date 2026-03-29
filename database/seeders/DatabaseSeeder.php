<?php

namespace Database\Seeders;

use App\Models\Utility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Step 1: Notification Seeder
        $this->call(NotificationSeeder::class);

        // Step 2: Module migrate & seed
        Artisan::call('module:migrate LandingPage');
        Artisan::call('module:seed LandingPage');

        // Step 3: Run all other seeders unconditionally
        try {
            $this->call(PlansTableSeeder::class);
        } catch (\Exception $e) {
            echo "PlansTableSeeder skipped: " . $e->getMessage() . PHP_EOL;
        }

        try {
            $this->call(UsersTableSeeder::class);
        } catch (\Exception $e) {
            echo "UsersTableSeeder skipped: " . $e->getMessage() . PHP_EOL;
        }

        try {
            $this->call(AiTemplateSeeder::class);
        } catch (\Exception $e) {
            echo "AiTemplateSeeder skipped: " . $e->getMessage() . PHP_EOL;
        }

        // Step 4: Optional utility function
        Utility::languagecreate();
    }
}