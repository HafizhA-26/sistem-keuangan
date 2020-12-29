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
        $id = "TC001";
        for ($i=0; $i < 10; $i++) { 
            $counterlen = strlen((string)$i+1);
            $id = substr_replace($id,(string)$i+1,$counterlen*-1);
            Transaksi::create([
                'id_transaksi' => $id,
                'id_dana' => $dana[rand(0,1)],
                'jumlah' => rand(1000,1000000),
                'jenis' => 'keluar'
            ]);
        }
    }
}
