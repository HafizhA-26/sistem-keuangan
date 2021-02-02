<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dana;
class DanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dana::create([
            'id_dana'   => 'BOS',
            'jumlah' =>  '10000000'
        ]);
        Dana::create([
        
            'id_dana'   => 'APBD',
            'jumlah' =>  '10000000'
            
        ]);
    }
}
