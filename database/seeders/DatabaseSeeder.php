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
            AccountTableSeeder::class,
            JabatanSeeder::class,
            DetailAccount::class,
            DanaSeeder::class,
            JurusanSeeder::class,
            // TransaksiSeeder::class, Hapus Komen Jika butuh
            // SubmissionSeeder::class, Hapus Komen Jika butuh
            // CommentsSeeder::class, Hapus Komen Jika butuh
        ]);
    }
}
