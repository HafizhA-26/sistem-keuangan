<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Transaksi;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dana = ['BOS','APBD'];
        $id = "TC0";
        for ($i=0; $i < 3; $i++) { 
            Transaksi::create([
                'id_transaksi' => $id.($i+1),
                'id_dana' => $dana[rand(0,1)],
                'jumlah' => rand(1000,1000000),
                'jenis' => 'keluar'
            ]);
        }
    }
}
