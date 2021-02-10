<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            JurusanSeeder::class,
            JabatanSeeder::class,
            AccountTableSeeder::class,
            DetailAccount::class,
            DanaSeeder::class,
            TransaksiSeeder::class, 
            SubmissionSeeder::class, 
            CommentsSeeder::class, 
        ]);
    }
}
